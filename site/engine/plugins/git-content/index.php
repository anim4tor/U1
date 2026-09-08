<?php

/**
 * Kirby Git Content Sync Plugin
 *
 * Automatically captures content updates from Kirby Panel on the server
 * and synchronizes them via GitHub REST API to the dedicated 'content' branch
 * and target branches (e.g. content, design, v2, v3, main).
 *
 * Implements non-blocking background synchronization with fastcgi_finish_request()
 * and session_write_close() to keep Panel saves fast and prevent session lockouts.
 * Compatible with Kirby 4 and 5 multilingual content structures.
 */

namespace U1\GitContent;

use Kirby\Cms\App as KirbyApp;
use Kirby\Http\Response;

class GitContentService
{
    protected static array $queue = [
        'push'   => [],
        'delete' => []
    ];
    protected static bool $shutdownRegistered = false;

    public static function getConfig(): array
    {
        $defaults = [
            'enabled'  => true,
            'repo'     => 'anim4tor/U1',
            'token'    => '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',
            'branches' => ['content', 'design', 'v2', 'v3', 'main'],
            'secret'   => 'maiden37',
            'author'   => [
                'name'  => 'Kirby Panel (Server)',
                'email' => 'panel@u1.cz'
            ],
            'log'      => true
        ];

        $userConfig = kirby()->option('u1.git-content', []);
        return array_replace_recursive($defaults, is_array($userConfig) ? $userConfig : []);
    }

    public static function isEnabled(): bool
    {
        $config = self::getConfig();
        return !empty($config['enabled']) && !empty($config['token']) && !empty($config['repo']);
    }

    public static function enqueuePush(string $fullPath): void
    {
        if (!self::isEnabled()) {
            return;
        }

        $contentRoot = kirby()->root('content');
        if (!$contentRoot) {
            return;
        }

        $normContent = rtrim(str_replace('\\', '/', realpath($contentRoot) ?: $contentRoot), '/');
        $normPath    = str_replace('\\', '/', realpath($fullPath) ?: $fullPath);

        if (!file_exists($fullPath) || is_dir($fullPath)) {
            return;
        }

        $filename = basename($normPath);
        // Skip lock files, hidden files, and temporary OS artifacts
        if (
            str_ends_with($filename, '.lock') ||
            str_starts_with($filename, '.') ||
            $filename === 'Thumbs.db' ||
            $filename === '.DS_Store'
        ) {
            return;
        }

        if (str_starts_with($normPath, $normContent)) {
            $sub = substr($normPath, strlen($normContent));
            $relative = 'public/content/' . ltrim($sub, '/');

            // Ignore virtual social items
            if (str_contains($relative, 'instagram-') || str_contains($relative, 'linkedin-')) {
                return;
            }

            self::$queue['push'][$relative] = $fullPath;
            self::registerShutdown();
        }
    }

    public static function enqueueDelete(string $relativePath): void
    {
        if (!self::isEnabled()) {
            return;
        }

        $clean = str_replace('\\', '/', $relativePath);
        $filename = basename($clean);
        if (str_ends_with($filename, '.lock') || str_starts_with($filename, '.')) {
            return;
        }

        if (str_contains($clean, 'instagram-') || str_contains($clean, 'linkedin-')) {
            return;
        }

        if (!str_starts_with($clean, 'public/content/')) {
            $clean = 'public/content/' . ltrim($clean, '/');
        }

        self::$queue['delete'][$clean] = true;
        self::registerShutdown();
    }

    /**
     * Enqueue all content files (*.txt) for a given Kirby page (all languages).
     */
    public static function enqueuePage($page): void
    {
        if (!$page) {
            return;
        }

        // 1. Check storage()->contentFiles() (Kirby 4/5 content storage)
        if (method_exists($page, 'storage')) {
            try {
                $storage = $page->storage();
                if (method_exists($storage, 'contentFiles')) {
                    foreach ($storage->contentFiles() as $file) {
                        if (is_string($file)) {
                            self::enqueuePush($file);
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 2. Check contentFiles()
        if (method_exists($page, 'contentFiles')) {
            try {
                foreach ($page->contentFiles() as $file) {
                    if (is_string($file)) {
                        self::enqueuePush($file);
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 3. Check contentFile()
        if (method_exists($page, 'contentFile')) {
            try {
                $cf = $page->contentFile();
                if (is_string($cf)) {
                    self::enqueuePush($cf);
                }
            } catch (\Throwable $e) {}
        }

        // 4. Reliable scan: scan page directory directly for all *.txt files
        if (method_exists($page, 'root')) {
            $dir = $page->root();
            if ($dir && is_dir($dir)) {
                $files = glob($dir . '/*.txt') ?: [];
                foreach ($files as $f) {
                    self::enqueuePush($f);
                }
            }
        }
    }

    /**
     * Enqueue all global site content files (site.*.txt).
     */
    public static function enqueueSite($site): void
    {
        if (!$site) {
            return;
        }

        if (method_exists($site, 'storage')) {
            try {
                $storage = $site->storage();
                if (method_exists($storage, 'contentFiles')) {
                    foreach ($storage->contentFiles() as $file) {
                        if (is_string($file)) {
                            self::enqueuePush($file);
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        if (method_exists($site, 'contentFiles')) {
            try {
                foreach ($site->contentFiles() as $file) {
                    if (is_string($file)) {
                        self::enqueuePush($file);
                    }
                }
            } catch (\Throwable $e) {}
        }

        $contentRoot = kirby()->root('content');
        if ($contentRoot && is_dir($contentRoot)) {
            $files = glob($contentRoot . '/*.txt') ?: [];
            foreach ($files as $f) {
                self::enqueuePush($f);
            }
        }
    }

    /**
     * Enqueue a file asset and any corresponding metadata *.txt files.
     */
    public static function enqueueFile($file): void
    {
        if (!$file) {
            return;
        }

        if (method_exists($file, 'root')) {
            $root = $file->root();
            self::enqueuePush($root);

            $dir  = dirname($root);
            $name = $file->filename();
            $metaFiles = glob($dir . '/' . $name . '*.txt') ?: [];
            foreach ($metaFiles as $mf) {
                self::enqueuePush($mf);
            }
        }
    }

    public static function registerShutdown(): void
    {
        if (self::$shutdownRegistered) {
            return;
        }
        self::$shutdownRegistered = true;

        register_shutdown_function(function () {
            @ignore_user_abort(true);
            if (function_exists('set_time_limit')) {
                @set_time_limit(180);
            }

            // 1. Release PHP session lock immediately so subsequent Panel AJAX requests are never blocked
            if (session_status() === PHP_SESSION_ACTIVE) {
                @session_write_close();
            }

            // 2. Finish FastCGI request to browser immediately (Panel UI turns green instantly)
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }

            // 3. Process GitHub API sync in the background
            self::processQueue();
        });
    }

    public static function processQueue(): array
    {
        $config   = self::getConfig();
        $branches = (array)($config['branches'] ?? ['content']);
        $results  = [];

        if (empty(self::$queue['push']) && empty(self::$queue['delete'])) {
            return ['status' => 'empty', 'message' => 'No files to process'];
        }

        foreach (self::$queue['push'] as $repoPath => $localPath) {
            if (!file_exists($localPath)) {
                continue;
            }
            $content = file_get_contents($localPath);
            foreach ($branches as $branch) {
                $res = self::pushFileToGitHub($config, $repoPath, $content, $branch);
                $results[] = [
                    'action' => 'push',
                    'path'   => $repoPath,
                    'branch' => $branch,
                    'result' => $res
                ];
            }
        }

        foreach (array_keys(self::$queue['delete']) as $repoPath) {
            foreach ($branches as $branch) {
                $res = self::deleteFileFromGitHub($config, $repoPath, $branch);
                $results[] = [
                    'action' => 'delete',
                    'path'   => $repoPath,
                    'branch' => $branch,
                    'result' => $res
                ];
            }
        }

        self::$queue = ['push' => [], 'delete' => []];

        if (!empty($config['log'])) {
            self::logResults($results);
        }

        return ['status' => 'success', 'results' => $results];
    }

    protected static function pushFileToGitHub(array $config, string $path, string $content, string $branch): array
    {
        $repo  = $config['repo'];
        $token = $config['token'];
        $url   = "https://api.github.com/repos/{$repo}/contents/{$path}?ref={$branch}";

        // Step 1: Check if file already exists on this branch to obtain SHA
        $existingSha = null;
        $getRes = self::githubRequest('GET', $url, $token);
        if ($getRes['http_code'] === 200 && !empty($getRes['data']['sha'])) {
            $existingSha = $getRes['data']['sha'];
            // Check if content is already identical to save API calls
            $existingContent = str_replace(["\r\n", "\n"], '', $getRes['data']['content'] ?? '');
            $newContentB64   = base64_encode($content);
            if ($existingContent === $newContentB64) {
                return ['status' => 'skipped', 'message' => 'Content is already identical', 'http_code' => 200];
            }
        }

        // Step 2: PUT updated file content
        $putUrl = "https://api.github.com/repos/{$repo}/contents/{$path}";
        $payload = [
            'message'   => "content(sync): update {$path}",
            'content'   => base64_encode($content),
            'branch'    => $branch,
            'committer' => $config['author'],
            'author'    => $config['author']
        ];
        if ($existingSha) {
            $payload['sha'] = $existingSha;
        }

        $putRes = self::githubRequest('PUT', $putUrl, $token, $payload);
        return [
            'status'    => ($putRes['http_code'] === 200 || $putRes['http_code'] === 201) ? 'success' : 'error',
            'http_code' => $putRes['http_code'],
            'response'  => $putRes['data'] ?? $putRes['raw']
        ];
    }

    protected static function deleteFileFromGitHub(array $config, string $path, string $branch): array
    {
        $repo  = $config['repo'];
        $token = $config['token'];
        $url   = "https://api.github.com/repos/{$repo}/contents/{$path}?ref={$branch}";

        $getRes = self::githubRequest('GET', $url, $token);
        if ($getRes['http_code'] !== 200 || empty($getRes['data']['sha'])) {
            return ['status' => 'skipped', 'message' => 'File does not exist on branch', 'http_code' => $getRes['http_code']];
        }

        $sha = $getRes['data']['sha'];
        $deletePayload = [
            'message'   => "content(sync): delete {$path}",
            'sha'       => $sha,
            'branch'    => $branch,
            'committer' => $config['author'],
            'author'    => $config['author']
        ];

        $delRes = self::githubRequest('DELETE', "https://api.github.com/repos/{$repo}/contents/{$path}", $token, $deletePayload);
        return [
            'status'    => ($delRes['http_code'] === 200) ? 'success' : 'error',
            'http_code' => $delRes['http_code'],
            'response'  => $delRes['data'] ?? $delRes['raw']
        ];
    }

    public static function githubRequest(string $method, string $url, string $token, ?array $payload = null): array
    {
        $ch = curl_init($url);
        $headers = [
            'User-Agent: Kirby-GitContent-Client',
            'Authorization: Bearer ' . $token,
            'Accept: application/vnd.github.v3+json',
            'Content-Type: application/json'
        ];

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true
        ];

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $knownCas = [
                ini_get('curl.cainfo'),
                ini_get('openssl.cafile'),
                'C:/Program Files/Git/mingw64/etc/ssl/certs/ca-bundle.crt',
                'C:/Program Files/Git/usr/ssl/certs/ca-bundle.crt',
                'D:/WampServer/bin/php/cacert.pem'
            ];
            $foundCa = null;
            foreach ($knownCas as $ca) {
                if ($ca && file_exists($ca)) {
                    $foundCa = $ca;
                    break;
                }
            }
            if ($foundCa) {
                $options[CURLOPT_CAINFO] = $foundCa;
            } else {
                $options[CURLOPT_SSL_VERIFYPEER] = false;
            }
        }

        if ($method === 'PUT') {
            $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
            $options[CURLOPT_POSTFIELDS]    = json_encode($payload, JSON_UNESCAPED_SLASHES);
        } elseif ($method === 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            $options[CURLOPT_POSTFIELDS]    = json_encode($payload, JSON_UNESCAPED_SLASHES);
        } elseif ($method === 'POST') {
            $options[CURLOPT_POST]       = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($payload, JSON_UNESCAPED_SLASHES);
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        $data = null;
        if ($response) {
            $data = json_decode($response, true);
        }

        return [
            'http_code' => $httpCode,
            'data'      => $data,
            'raw'       => $response,
            'error'     => $error
        ];
    }

    protected static function logResults(array $results): void
    {
        $logDir = kirby()->root('logs') ?? (kirby()->root('site') . '/store/logs');
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0775, true);
        }
        $logFile = $logDir . '/git-content.json';
        $entry = [
            'time'    => date('Y-m-d H:i:s'),
            'results' => $results
        ];

        $existing = [];
        if (file_exists($logFile)) {
            $content = @file_get_contents($logFile);
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $existing = $decoded;
            }
        }
        array_unshift($existing, $entry);
        if (count($existing) > 50) {
            $existing = array_slice($existing, 0, 50);
        }
        @file_put_contents($logFile, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}

/**
 * Register Kirby Plugin and Hooks
 */
KirbyApp::plugin('u1/git-content', [
    'hooks' => [
        'page.create:after' => function ($page) {
            GitContentService::enqueuePage($page);
            foreach ($page->files() as $file) {
                GitContentService::enqueueFile($file);
            }
        },
        'page.update:after' => function ($newPage, $oldPage) {
            GitContentService::enqueuePage($newPage);
        },
        'page.changeTitle:after' => function ($newPage, $oldPage) {
            GitContentService::enqueuePage($newPage);
        },
        'page.changeStatus:after' => function ($newPage, $oldPage) {
            GitContentService::enqueuePage($newPage);
        },
        'page.changeSlug:after' => function ($newPage, $oldPage) {
            GitContentService::enqueuePage($newPage);
            if ($oldPage && method_exists($oldPage, 'root') && method_exists($newPage, 'root') && $oldPage->root() !== $newPage->root()) {
                $contentRoot = kirby()->root('content');
                $rel = 'public/content/' . ltrim(substr($oldPage->root(), strlen($contentRoot)), '/\\');
                GitContentService::enqueueDelete($rel);
            }
        },
        'page.delete:after' => function ($status, $page) {
            if ($page && method_exists($page, 'root')) {
                $contentRoot = kirby()->root('content');
                $relativeDir = 'public/content/' . ltrim(substr($page->root(), strlen($contentRoot)), '/\\');
                GitContentService::enqueueDelete($relativeDir);
            }
        },
        'site.update:after' => function ($newSite, $oldSite) {
            GitContentService::enqueueSite($newSite);
        },
        'file.create:after' => function ($file) {
            GitContentService::enqueueFile($file);
        },
        'file.replace:after' => function ($newFile, $oldFile) {
            GitContentService::enqueueFile($newFile);
        },
        'file.delete:after' => function ($status, $file) {
            if ($file && method_exists($file, 'root')) {
                $contentRoot = kirby()->root('content');
                $rel = 'public/content/' . ltrim(substr($file->root(), strlen($contentRoot)), '/\\');
                GitContentService::enqueueDelete($rel);
            }
        }
    ],
    'routes' => [
        [
            'pattern' => ['api-git-content-sync', 'git-content-sync.json'],
            'method'  => 'GET|POST',
            'action'  => function () {
                $config = GitContentService::getConfig();
                $secret = get('secret') ?? (kirby()->request()->data()['secret'] ?? '');

                if (empty($secret) || !hash_equals($config['secret'], $secret)) {
                    return Response::json(['status' => 'error', 'message' => 'Unauthorized'], 401);
                }

                if (get('check')) {
                    $test = GitContentService::githubRequest('GET', "https://api.github.com/repos/{$config['repo']}", $config['token']);
                    return Response::json([
                        'status'       => $test['http_code'] === 200 ? 'ok' : 'error',
                        'github_repo'  => $config['repo'],
                        'github_code'  => $test['http_code'],
                        'branches'     => $config['branches'],
                        'permissions'  => $test['data']['permissions'] ?? null
                    ]);
                }

                // If testing push of a specific page or all content
                if (get('sync_now')) {
                    $contentRoot = kirby()->root('content');
                    $iterator = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($contentRoot, \RecursiveDirectoryIterator::SKIP_DOTS)
                    );
                    foreach ($iterator as $f) {
                        if ($f->isFile() && str_ends_with($f->getFilename(), '.txt') && !str_starts_with($f->getFilename(), '.')) {
                            GitContentService::enqueuePush($f->getPathname());
                        }
                    }
                }

                $res = GitContentService::processQueue();
                return Response::json($res);
            }
        ]
    ]
]);
