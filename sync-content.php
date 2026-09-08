<?php
/**
 * Standalone Git Content Synchronizer & Diagnostic Tool for U1
 *
 * Usage:
 *   Healthcheck: https://jiriklusak.cz/projects/U1/sync-content.php?secret=maiden37&check=1
 *   View log:    https://jiriklusak.cz/projects/U1/sync-content.php?secret=maiden37&log=1
 *   Sync all:    https://jiriklusak.cz/projects/U1/sync-content.php?secret=maiden37&sync_all=1
 */

header('Content-Type: application/json; charset=utf-8');
ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');
ignore_user_abort(true);

$secret       = 'maiden37';
$repo         = 'anim4tor/U1';
$githubToken  = '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';
$targetBranches = ['content', 'design', 'v2', 'v3', 'main'];
$contentDir   = __DIR__ . '/public/content';
$logFile      = __DIR__ . '/site/store/logs/git-content.json';

$providedSecret = $_REQUEST['secret'] ?? '';
if (empty($providedSecret) || !hash_equals($secret, $providedSecret)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: invalid or missing secret.']);
    exit;
}

// 1. View logs
if (isset($_GET['log'])) {
    if (file_exists($logFile)) {
        echo file_get_contents($logFile);
    } else {
        echo json_encode(['status' => 'no_log_found', 'path' => $logFile]);
    }
    exit;
}

// Helper: GitHub API request
function u1GithubApi(string $method, string $url, string $token, ?array $payload = null): array {
    $ch = curl_init($url);
    $headers = [
        'User-Agent: U1-SyncContent-Script',
        'Authorization: Bearer ' . $token,
        'Accept: application/vnd.github.v3+json',
        'Content-Type: application/json'
    ];
    $opts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
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
            $opts[CURLOPT_CAINFO] = $foundCa;
        } else {
            $opts[CURLOPT_SSL_VERIFYPEER] = false;
        }
    }
    if ($method === 'PUT') {
        $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
        $opts[CURLOPT_POSTFIELDS]    = json_encode($payload, JSON_UNESCAPED_SLASHES);
    } elseif ($method === 'DELETE') {
        $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        $opts[CURLOPT_POSTFIELDS]    = json_encode($payload, JSON_UNESCAPED_SLASHES);
    }
    curl_setopt_array($ch, $opts);
    $raw  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    return [
        'code'  => $code,
        'data'  => $raw ? json_decode($raw, true) : null,
        'raw'   => $raw,
        'error' => $err
    ];
}

// 2. Healthcheck
if (isset($_GET['check'])) {
    $repoCheck = u1GithubApi('GET', "https://api.github.com/repos/{$repo}", $githubToken);
    $branchesCheck = u1GithubApi('GET', "https://api.github.com/repos/{$repo}/branches", $githubToken);
    $activeBranches = [];
    if ($branchesCheck['code'] === 200 && is_array($branchesCheck['data'])) {
        $activeBranches = array_column($branchesCheck['data'], 'name');
    }

    echo json_encode([
        'status'         => ($repoCheck['code'] === 200) ? 'ok' : 'error',
        'repo'           => $repo,
        'repo_http_code' => $repoCheck['code'],
        'permissions'    => $repoCheck['data']['permissions'] ?? null,
        'all_branches'   => $activeBranches,
        'sync_targets'   => $targetBranches,
        'content_dir'    => [
            'path'   => $contentDir,
            'exists' => is_dir($contentDir),
            'files'  => is_dir($contentDir) ? count(glob($contentDir . '/*')) : 0
        ],
        'session_lock_prevention' => function_exists('fastcgi_finish_request') ? 'fastcgi_finish_request_available' : 'shutdown_only'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// 3. Sync all text content to GitHub
if (isset($_GET['sync_all'])) {
    if (!is_dir($contentDir)) {
        echo json_encode(['status' => 'error', 'message' => 'Content directory does not exist.']);
        exit;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($contentDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    $filesToSync = [];
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $filename = $file->getFilename();
            // Only sync text files and skip locks / hidden
            $pathNorm = str_replace('\\', '/', $file->getPathname());
            if (str_contains($pathNorm, '/instagram-') || str_contains($pathNorm, '/linkedin-')) {
                continue;
            }

            if (
                str_ends_with($filename, '.txt') &&
                !str_starts_with($filename, '.') &&
                !str_ends_with($filename, '.lock')
            ) {
                $filesToSync[] = $file->getPathname();
            }
        }
    }

    $branches = !empty($_GET['branch']) ? [$_GET['branch']] : $targetBranches;
    $results = [];

    foreach ($filesToSync as $filePath) {
        $relPath = 'public/content/' . ltrim(str_replace('\\', '/', substr($filePath, strlen($contentDir))), '/');
        $content = file_get_contents($filePath);

        foreach ($branches as $branch) {
            // Check existing SHA
            $getUrl = "https://api.github.com/repos/{$repo}/contents/{$relPath}?ref={$branch}";
            $getRes = u1GithubApi('GET', $getUrl, $githubToken);

            $existingSha = null;
            if ($getRes['code'] === 200 && !empty($getRes['data']['sha'])) {
                $existingSha = $getRes['data']['sha'];
                $existingB64 = str_replace(["\r\n", "\n"], '', $getRes['data']['content'] ?? '');
                if ($existingB64 === base64_encode($content)) {
                    $results[] = ['file' => $relPath, 'branch' => $branch, 'status' => 'identical'];
                    continue;
                }
            }

            $putUrl = "https://api.github.com/repos/{$repo}/contents/{$relPath}";
            $payload = [
                'message'   => "content(bulk-sync): update {$relPath}",
                'content'   => base64_encode($content),
                'branch'    => $branch,
                'committer' => ['name' => 'Kirby Panel (Bulk Sync)', 'email' => 'panel@u1.cz'],
                'author'    => ['name' => 'Kirby Panel (Bulk Sync)', 'email' => 'panel@u1.cz']
            ];
            if ($existingSha) {
                $payload['sha'] = $existingSha;
            }

            $putRes = u1GithubApi('PUT', $putUrl, $githubToken, $payload);
            $results[] = [
                'file'   => $relPath,
                'branch' => $branch,
                'status' => in_array($putRes['code'], [200, 201]) ? 'synced' : 'error',
                'code'   => $putRes['code']
            ];
        }
    }

    echo json_encode([
        'status'         => 'success',
        'files_scanned'  => count($filesToSync),
        'branches'       => $branches,
        'results_summary'=> array_count_values(array_column($results, 'status')),
        'results'        => $results
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

echo json_encode([
    'status'  => 'ready',
    'usage'   => [
        'check'    => '?secret=maiden37&check=1',
        'log'      => '?secret=maiden37&log=1',
        'sync_all' => '?secret=maiden37&sync_all=1 (&branch=content)'
    ]
]);
