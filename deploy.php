<?php
/**
 * Instant Pure-PHP GitHub Auto-Deployment via ZipArchive
 * Works on all shared hosting environments without Git binary or SSH.
 *
 * Accessible at: https://jiriklusak.cz/projects/U1/deploy.php
 */

header('Content-Type: application/json; charset=utf-8');
ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');
ignore_user_abort(true);

// ==============================================================================
// 1. CONFIGURATION
// ==============================================================================
$secret       = 'maiden37';
$repo         = 'anim4tor/U1';
$activeBranch = (file_exists(__DIR__ . '/.current-branch') ? trim((string)@file_get_contents(__DIR__ . '/.current-branch')) : '') ?: 'v3';
$targetBranch = $_REQUEST['branch'] ?? $activeBranch;
$githubToken  = $_REQUEST['token'] ?? (file_exists(__DIR__ . '/.env') ? (@parse_ini_file(__DIR__ . '/.env')['GITHUB_TOKEN'] ?? null) : null) ?: base64_decode('Z2hwXzNCRGY0bWE5R0t5Tk1ieXBvMGxQZnRVVW45ajJQcTRnSVp1UA==');
$projectDir   = __DIR__;
$logFile      = __DIR__ . '/deploy-log.json';

// Exclude these existing server paths from being overwritten
$preservePaths = [
    'public/media',
    'site/cache',
    'site/accounts',
    '.env',
    'deploy.php',
    'deploy-log.json',
    '.current-branch'
];

// Completely skip extracting these development / build files:
$ignorePatterns = [
    'node_modules',
    'scripts',
    '.github',
    '.git',
    '.gitignore',
    '.gitattributes',
    '.vscode',
    '.idea',
    'bs-config.js',
    'package.json',
    'package-lock.json',
    'prepros.config',
    '*.sublime-*',
    '*.code-workspace'
];

// If requesting log view: ?secret=maiden37&log=1
if (isset($_GET['log']) && isset($_GET['secret']) && hash_equals($secret, $_GET['secret'])) {
    if (file_exists($logFile)) {
        echo file_get_contents($logFile);
    } else {
        echo json_encode(['status' => 'no_log_yet']);
    }
    exit;
}

// ==============================================================================
// 2. AUTHENTICATION & SECURITY
// ==============================================================================
$rawPayload      = file_get_contents('php://input');
$signatureHeader = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$isAuthenticated = false;

// Method A: GitHub HMAC-SHA256 signature
if ($signatureHeader && str_starts_with($signatureHeader, 'sha256=')) {
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $rawPayload, $secret);
    if (hash_equals($expectedSignature, $signatureHeader)) {
        $isAuthenticated = true;
    }
}

// Method B: Manual trigger via ?secret=...
if (!$isAuthenticated && isset($_GET['secret']) && hash_equals($secret, $_GET['secret'])) {
    $isAuthenticated = true;
}

if (!$isAuthenticated) {
    http_response_code(403);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Unauthorized: Invalid or missing secret/signature.'
    ], JSON_PRETTY_PRINT);
    exit;
}

// Check branch if payload came from GitHub push event
$payload = json_decode($rawPayload, true);
if ($payload && isset($payload['ref'])) {
    $pushedBranch = str_replace('refs/heads/', '', $payload['ref']);
    if (!isset($_REQUEST['branch'])) {
        $targetBranch = $pushedBranch;
        if ($pushedBranch !== $activeBranch) {
            echo json_encode([
                'status'  => 'ignored',
                'message' => "Push was to '{$pushedBranch}', but active branch on server is '{$activeBranch}'. Deployment skipped."
            ], JSON_PRETTY_PRINT);
            exit;
        }
    } else {
        $expectedRef = 'refs/heads/' . $targetBranch;
        if ($payload['ref'] !== $expectedRef) {
            echo json_encode([
                'status'  => 'ignored',
                'message' => "Push was to '{$payload['ref']}', target branch is '{$expectedRef}'. Deployment skipped."
            ], JSON_PRETTY_PRINT);
            exit;
        }
    }
}

// If sent via GitHub Webhook POST, acknowledge 200 OK immediately so GitHub doesn't timeout!
$isAsyncWebhook = (!empty($rawPayload) && !empty($signatureHeader));

if ($isAsyncWebhook) {
    if (function_exists('fastcgi_finish_request')) {
        echo json_encode([
            'status'  => 'processing',
            'message' => 'Deployment queued and executing in background.'
        ]);
        fastcgi_finish_request();
    } else {
        ob_start();
        echo json_encode([
            'status'  => 'processing',
            'message' => 'Deployment queued and executing in background.'
        ]);
        $responseSize = ob_get_length();
        header("Content-Length: {$responseSize}");
        header("Connection: close");
        ob_end_flush();
        @ob_flush();
        flush();
    }
}

// ==============================================================================
// 3. EXECUTE DOWNLOAD & EXTRACTION
// ==============================================================================
$startTime = microtime(true);

if (!empty($githubToken)) {
    $zipUrl = "https://api.github.com/repos/{$repo}/zipball/{$targetBranch}";
} else {
    $zipUrl = "https://github.com/{$repo}/archive/refs/heads/{$targetBranch}.zip";
}

$tempZip = sys_get_temp_dir() . '/deploy_' . uniqid() . '.zip';

$headers = [
    'User-Agent: PHP-AutoDeploy-Client'
];
if (!empty($githubToken)) {
    $headers[] = "Authorization: Bearer {$githubToken}";
    $headers[] = 'Accept: application/vnd.github.v3+json';
}

$ch = curl_init($zipUrl);
$fp = fopen($tempZip, 'w+');

curl_setopt_array($ch, [
    CURLOPT_TIMEOUT        => 120,
    CURLOPT_FILE           => $fp,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_HTTPHEADER     => $headers,
    CURLOPT_SSL_VERIFYPEER => true
]);

$success = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);
fclose($fp);

$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'branch'    => $targetBranch
];

if (!$success || $httpCode >= 400 || filesize($tempZip) === 0) {
    @unlink($tempZip);
    $logData['status']  = 'error';
    $logData['message'] = "Failed to download zip from GitHub (HTTP {$httpCode})." . ($error ? " Error: {$error}" : '');
    file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));
    
    if (!$isAsyncWebhook) {
        http_response_code(500);
        echo json_encode($logData, JSON_PRETTY_PRINT);
    }
    exit;
}

if (!class_exists('ZipArchive')) {
    @unlink($tempZip);
    $logData['status']  = 'error';
    $logData['message'] = 'ZipArchive extension not enabled in PHP.';
    file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));
    
    if (!$isAsyncWebhook) {
        http_response_code(500);
        echo json_encode($logData, JSON_PRETTY_PRINT);
    }
    exit;
}

$zip = new ZipArchive();
if ($zip->open($tempZip) !== true) {
    @unlink($tempZip);
    $logData['status']  = 'error';
    $logData['message'] = 'Failed to open downloaded zip file.';
    file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));
    
    if (!$isAsyncWebhook) {
        http_response_code(500);
        echo json_encode($logData, JSON_PRETTY_PRINT);
    }
    exit;
}

// GitHub zipballs have a root directory (e.g. anim4tor-U1-abc1234/)
$rootPrefix = $zip->getNameIndex(0);
if (!str_ends_with($rootPrefix, '/')) {
    $rootPrefix = '';
}

$extractedCount = 0;
$skippedCount   = 0;

for ($i = 0; $i < $zip->numFiles; $i++) {
    $entryName = $zip->getNameIndex($i);
    
    // Strip the GitHub root prefix
    if (!empty($rootPrefix) && str_starts_with($entryName, $rootPrefix)) {
        $relativePath = substr($entryName, strlen($rootPrefix));
    } else {
        $relativePath = $entryName;
    }

    if (empty($relativePath)) continue;

    // Check if path is ignored (node_modules, dev configs, scripts, etc.)
    $isIgnored = false;
    foreach ($ignorePatterns as $pattern) {
        if ($relativePath === $pattern || str_starts_with($relativePath, $pattern . '/')) {
            $isIgnored = true;
            break;
        }
        if (fnmatch($pattern, $relativePath)) {
            $isIgnored = true;
            break;
        }
    }

    if ($isIgnored) {
        $skippedCount++;
        continue;
    }

    // Check preserved paths
    $isPreserved = false;
    foreach ($preservePaths as $preserve) {
        if ($relativePath === $preserve || str_starts_with($relativePath, $preserve . '/')) {
            $isPreserved = true;
            break;
        }
    }

    if ($isPreserved) {
        $skippedCount++;
        continue;
    }

    $destPath = $projectDir . '/' . $relativePath;

    if (str_ends_with($entryName, '/')) {
        if (!is_dir($destPath)) {
            @mkdir($destPath, 0755, true);
        }
        continue;
    }

    $parentDir = dirname($destPath);
    if (!is_dir($parentDir)) {
        @mkdir($parentDir, 0755, true);
    }

    $fileContent = $zip->getFromIndex($i);
    if ($fileContent !== false) {
        @file_put_contents($destPath, $fileContent);
        $extractedCount++;
    }
}

$zip->close();
@unlink($tempZip);

// Record active branch
@file_put_contents($projectDir . '/.current-branch', $targetBranch);

// Flush caches
$cacheDirs = [
    $projectDir . '/site/cache',
    $projectDir . '/site/store/cache'
];
foreach ($cacheDirs as $cDir) {
    if (is_dir($cDir)) {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($cDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($it as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            @$todo($fileinfo->getRealPath());
        }
    }
}

$duration = round((microtime(true) - $startTime) * 1000, 2);

$logData['status']          = 'success';
$logData['message']         = 'Deployment completed successfully via PHP ZipArchive.';
$logData['files_extracted'] = $extractedCount;
$logData['files_preserved'] = $skippedCount;
$logData['execution_time']  = "{$duration}ms";

file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));

if (!$isAsyncWebhook) {
    echo json_encode($logData, JSON_PRETTY_PRINT);
}
