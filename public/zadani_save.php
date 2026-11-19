<?php
/**
 * Direct Fallback State Handler for Zadani
 * Writes & reads zadani_state.json across server environments
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-cache, no-store, must-revalidate');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$locations = array_unique(array_filter([
    __DIR__ . '/zadani_state.json',
    dirname(__DIR__) . '/zadani_state.json',
    dirname(__DIR__) . '/public/zadani_state.json'
]));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents('php://input');
    $body = json_decode($raw, true);
    if (!is_array($body) && !empty($_POST)) {
        $body = $_POST;
    }
    $data = [
        'updated_at' => date('c'),
        'checked'    => $body['checked'] ?? []
    ];
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    foreach ($locations as $loc) {
        $dir = dirname($loc);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        @file_put_contents($loc, $json);
    }
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

// GET
$newestData = null;
$newestTime = 0;
foreach ($locations as $loc) {
    if (file_exists($loc)) {
        $mtime = filemtime($loc);
        $data = json_decode(file_get_contents($loc), true);
        if (is_array($data) && isset($data['checked']) && $mtime >= $newestTime) {
            $newestData = $data;
            $newestTime = $mtime;
        }
    }
}

if ($newestData) {
    echo json_encode($newestData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(['checked' => []]);
