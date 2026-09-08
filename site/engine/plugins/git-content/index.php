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

        $contentRoot = realpath(kirby()->root('content'));
        $realPath    = realpath($fullPath);

        if (!$realPath || !file_exists($realPath) || is_dir($realPath)) {
            return;
        }

        $filename = basename($realPath);
        // Skip lock files and hidden OS files
        if (
            str_ends_with($filename, '.lock') ||
            str_starts_with($filename, '.') ||
            $filename === 'Thumbs.db' ||
            $filename === '.DS_Store'
        ) {
            return;
        }

        if ($contentRoot && str_starts_with($realPath, $contentRoot)) {
            $relative = 'public/content/' . ltrim(str_replace('\\', '/', substr($realPath, strlen($contentRoot))), '/');
            self::$queue['push'][$relative] = $realPath;
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

        if (!str_starts_with($clean, 'public/content/')) {
            $clean = 'public/content/' . ltrim($clean, '/');
        }

        self::$queue['delete'][$clean] = true;
        self::registerShutdown();
    }

    public static function registerShutdown(): void
    {
        if (self::$shutdownRegistered) {
            return;
        }
        self::$shutdownRegistered = true;

        register_shutdown_function(function () {
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
            foreach ($page->files() as $file) {
                GitContentService::enqueuePush($file->root());
            }
            if ($textfile = $page->textfile()) {
                GitContentService::enqueuePush($textfile);
            }
        },
        'page.update:after' => function ($newPage, $oldPage) {
            if ($textfile = $newPage->textfile()) {
                GitContentService::enqueuePush($textfile);
            }
        },
        'page.changeTitle:after' => function ($newPage, $oldPage) {
            if ($textfile = $newPage->textfile()) {
                GitContentService::enqueuePush($textfile);
            }
        },
        'page.changeStatus:after' => function ($newPage, $oldPage) {
            if ($textfile = $newPage->textfile()) {
                GitContentService::enqueuePush($textfile);
            }
        },
        'page.changeSlug:after' => function ($newPage, $oldPage) {
            // Push new textfile and delete old reference
            if ($textfile = $newPage->textfile()) {
                GitContentService::enqueuePush($textfile);
            }
        },
        'page.delete:after' => function ($status, $page) {
            $contentRoot = kirby()->root('content');
            $relativeDir = 'public/content/' . ltrim(substr($page->root(), strlen($contentRoot)), '/\\');
            GitContentService::enqueueDelete($relativeDir);
        },
        'site.update:after' => function ($newSite, $oldSite) {
            if ($textfile = $newSite->textfile()) {
                GitContentService::enqueuePush($textfile);
            }
        },
        'file.create:after' => function ($file) {
            GitContentService::enqueuePush($file->root());
        },
        'file.replace:after' => function ($newFile, $oldFile) {
            GitContentService::enqueuePush($newFile->root());
        },
        'file.delete:after' => function ($status, $file) {
            $contentRoot = kirby()->root('content');
            $rel = 'public/content/' . ltrim(substr($file->root(), strlen($contentRoot)), '/\\');
            GitContentService::enqueueDelete($rel);
        }
    ],
    'routes' => [
        [
            'pattern' => ['api-git-content-sync', 'git-content-sync.json'],
            'method'  => ['GET', 'POST'],
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

                $res = GitContentService::processQueue();
                return Response::json($res);
            }
        ]
    ]
]);
