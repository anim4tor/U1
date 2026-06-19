<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Look down into the atom component folder for the generator script
$generatorScript = __DIR__ . '/site/components/atoms/Theme/generate-fonts.php';

if (file_exists($generatorScript)) {
    include($generatorScript);
}

if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: /");
}
exit;