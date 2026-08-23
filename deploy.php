<?php
/**
 * Instant Pure-PHP GitHub Auto-Deployment via ZipArchive
 * Works on all shared hosting environments without Git binary or SSH.
 *
 * Accessible at: https://jiriklusak.cz/projects/U1/deploy.php
 */

header('Content-Type: application/json; charset=utf-8');
ini_set('max_execution_time', 120);
ini_set('memory_limit', '256M');

// ==============================================================================
// 1. CONFIGURATION
// ==============================================================================
$secret       = 'maiden37';              // Your secret key
$repo         = 'anim4tor/U1';           // GitHub username/repository
$targetBranch = 'staging';               // Branch to deploy
$githubToken  = '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';                      // Optional GitHub Personal Access Token (if repo is private)
$projectDir   = __DIR__;                 // Destination directory

// Exclude these paths from being overwritten during extraction
$preservePaths = [
    'public/media',
    'site/cache',
    'site/accounts',
    '.env',
    'deploy.php'
];

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
    $expectedRef = 'refs/heads/' . $targetBranch;
    if ($payload['ref'] !== $expectedRef) {
        echo json_encode([
            'status'  => 'ignored',
            'message' => "Push was to '{$payload['ref']}', target branch is '{$expectedRef}'. Deployment skipped."
        ], JSON_PRETTY_PRINT);
        exit;
    }
}

// ==============================================================================
// 3. DOWNLOAD REPOSITORY ZIP
// ==============================================================================
$startTime = microtime(true);

if (!empty($githubToken)) {
    // Private repo API endpoint
    $zipUrl = "https://api.github.com/repos/{$repo}/zipball/{$targetBranch}";
} else {
    // Public repo direct zip endpoint
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
    CURLOPT_TIMEOUT        => 60,
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

if (!$success || $httpCode >= 400 || filesize($tempZip) === 0) {
    @unlink($tempZip);
    http_response_code(500);
    echo json_encode([
        'status'    => 'error',
        'message'   => "Failed to download zip from GitHub (HTTP {$httpCode})." . ($error ? " Error: {$error}" : ''),
        'zip_url'   => $zipUrl,
        'hint'      => empty($githubToken) ? 'If your repo is private, please set $githubToken in deploy.php.' : ''
    ], JSON_PRETTY_PRINT);
    exit;
}

// ==============================================================================
// 4. EXTRACT ZIP ARCHIVE WITH ZIPARCHIVE
// ==============================================================================
if (!class_exists('ZipArchive')) {
    @unlink($tempZip);
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'ZipArchive PHP extension is not enabled on this server.'
    ], JSON_PRETTY_PRINT);
    exit;
}

$zip = new ZipArchive();
if ($zip->open($tempZip) !== true) {
    @unlink($tempZip);
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to open downloaded zip archive.'
    ], JSON_PRETTY_PRINT);
    exit;
}

$extractedCount = 0;
$skippedCount = 0;

// GitHub archives contain a top-level directory (e.g. "U1-staging/" or "anim4tor-U1-1a2b3c/")
$firstEntry = $zip->getNameIndex(0);
$rootFolder = explode('/', $firstEntry)[0] . '/';

for ($i = 0; $i < $zip->numFiles; $i++) {
    $stat = $zip->statIndex($i);
    $entryName = $stat['name'];

    // Strip top-level root directory
    if (str_starts_with($entryName, $rootFolder)) {
        $relativePath = substr($entryName, strlen($rootFolder));
    } else {
        $relativePath = $entryName;
    }

    if (empty($relativePath)) continue;

    // Check if path is in preserved paths list
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

    // Create directories
    if (str_ends_with($entryName, '/')) {
        if (!is_dir($destPath)) {
            mkdir($destPath, 0755, true);
        }
        continue;
    }

    // Ensure parent directory exists
    $parentDir = dirname($destPath);
    if (!is_dir($parentDir)) {
        mkdir($parentDir, 0755, true);
    }

    // Extract file
    $fileContent = $zip->getFromIndex($i);
    if ($fileContent !== false) {
        file_put_contents($destPath, $fileContent);
        $extractedCount++;
    }
}

$zip->close();
@unlink($tempZip);

$duration = round((microtime(true) - $startTime) * 1000, 2);

// ==============================================================================
// 5. SUCCESS RESPONSE
// ==============================================================================
echo json_encode([
    'status'          => 'success',
    'message'         => 'Deployment completed successfully via PHP ZipArchive.',
    'timestamp'       => date('Y-m-d H:i:s'),
    'branch'          => $targetBranch,
    'files_extracted' => $extractedCount,
    'files_preserved' => $skippedCount,
    'execution_time'  => "{$duration}ms"
], JSON_PRETTY_PRINT);
