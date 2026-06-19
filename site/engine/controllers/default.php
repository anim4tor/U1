<?php

return function ($page, $kirby, $site) {

	// 1. 🔄 INTERCEPT FORM SUBMIT POST FOR GENERATOR EXECUTION
	if ($kirby->request()->is('POST') && get('action') === 'sync_theme_fonts') {
		$generatorScript = $kirby->root('site') . '/components/atoms/Theme/generate-fonts.php';
		if (file_exists($generatorScript)) {
			include($generatorScript);
		}
		go($page->url());
	}

	// 2. 📁 SCAN FONTS DIRECTORY DIRECTLY FOR DROPDOWN VALUES
	// Adjust directory levels if necessary to point to your public fonts location
	$fontsDirectory = $kirby->root('index') . '/public/assets/fonts';
	$discoveredFonts = [];

	if (is_dir($fontsDirectory)) {
		$files = array_diff(scandir($fontsDirectory), ['.', '..']);
		foreach ($files as $file) {
			$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			// Match font extensions
			if (in_array($extension, ['woff2', 'woff', 'ttf', 'otf'])) {
				$fileName = pathinfo($file, PATHINFO_FILENAME);
				// Extract primary font name family by removing weight/style tags (e.g., "Inter-Bold" -> "Inter")
				$fontFamily = explode('-', $fileName)[0];
				
				if (!in_array($fontFamily, $discoveredFonts)) {
					$discoveredFonts[] = $fontFamily;
				}
			}
		}
	}
	
	// Sort alphabetical
	sort($discoveredFonts);

	return [
		'discoveredFonts' => $discoveredFonts
	];
};