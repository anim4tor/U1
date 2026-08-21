<!-- Vendor js -->

<!-- The cookie elements --> 
<!-- <script type="module" src="/assets/js/cookieconsent-config.js"></script> -->

<!-- Global js -->
<?php 
$assetVersion = function($path) {
	$fullPath = kirby()->root('index') . '/' . ltrim($path, '/');
	return file_exists($fullPath) ? $path . '?v=' . filemtime($fullPath) : $path;
};
?>
<?= js($assetVersion('public/assets/js/app.dist.js')); ?>

<!-- Local js -->
<?php 
$templateJs = 'site/components/templates/' . ucwords($page->intendedTemplate()) . '/index.js';
if (file_exists(kirby()->root('index') . '/' . $templateJs)) : ?>
	<?= js($assetVersion($templateJs)) ?>
<?php endif ?>