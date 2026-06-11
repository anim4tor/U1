<?php
	$theme = page('theme');
?>
<?php
	$screenmobile   = '480px';
	$screentablet   = '768px';
	$screenlaptop   = '1280px';
	$screendesktop   = '1440px';
	$queries = [
	    'desktop'  => $screendesktop,
	    'laptop'  => $screenlaptop,
	    'tablet'  => $screentablet,
	    'mobile'  => $screenmobile,
	];
	function create_mq($content, $breakpoint, $minmax) {
	  if($breakpoint == 0) {
	    $content;
	  } else {
	  	echo "@media screen and ({$minmax}-width: {$breakpoint}) {
			      {$content}
			 }";
	  }
	}
?>
<style type="text/css">
	:root {
		/* spacing */
		
		--scale: <?= $theme->scale()->or(1.0)->toFloat()?>;
		--scale-fluid: <?= $theme->base()->or(2.0)->toFloat() ?>;
		--scale-min: <?= $theme->min()->or(1.0)->toFloat() ?>;
		--scale-vpad: <?= $theme->vpad()->toFloat() ?>;
		--scale-hpad: <?= $theme->hpad()->toFloat() ?>;
		--scale-gap: <?= $theme->gap()->or(0.5)->toFloat() + 0.5 ?>;
		--pad: Max(calc(var(--scale-min)*1rem),calc(var(--scale-fluid)*1vw*var(--scale)));
		--spacing: Max(calc(var(--scale-min)*1rem),calc(var(--scale-fluid)*1vw*var(--scale)));

		/* colors */
		
		<?php foreach ($theme->palette()->toStructure() as $color) : ?>
			--color-<?= $color->name() ?>: <?= $color->color() ?>;
		<?php endforeach ?>
		
		--background: <?= implode(',',sscanf($theme->bg(), "#%02x%02x%02x")) ?>;
		--col: <?= implode(',',sscanf($theme->col(), "#%02x%02x%02x")) ?>;

		/* typography */
		--font-base: <?= $theme->typebaseflexible()->toFloat() ?>;
		--font-heading-scale: <?= $theme->typescaleheading()->or(1.618)->toFloat() ?>;
		--font-body-scale: <?= $theme->typescalebody()->or(1.4)->toFloat() ?>;
		/*--font-family-body: <?= $theme->bodyFace() ?>;
		--font-family-heading: <?= $theme->headingface() ?>;
		--font-family-button: <?= $theme->buttonface() ?>;*/

		
		/* buttons */
		--button-vpad: <?= $theme->buttonvpad() ?>;
		--button-hpad: <?= $theme->buttonhpad() ?>;
		<?php foreach ($theme->buttons()->toStructure() as $button) : ?>
			--<?= $button->buttonname() ?>-button-face: <?= $button->buttonface() ?>;
			--<?= $button->buttonname() ?>-button-border-radius: <?= $button->buttonradius() ?>;
			--<?= $button->buttonname() ?>-button-border-width: <?= $button->buttonwidth() ?>;
			--<?= $button->buttonname() ?>-button-size: <?= $button->buttonsize() ?>;
		<?php endforeach ?>
		
		
	}
	<?php foreach ($theme->palette()->toStructure() as $color) : ?>
		.bg__<?= $color->name() ?> {
			--background: <?= implode(',',sscanf($color->color(), "#%02x%02x%02x")) ?>;
			background-color: <?= $color->color() ?>;
		}
		.color__<?= $color->name() ?> {
			--col: <?= implode(',',sscanf($color->color(), "#%02x%02x%02x")) ?>;
			color: <?= $color->color() ?>;
		}
		<?php foreach ($queries as $modifier => $breakpoint) : ?>
		  	<?php echo "@media screen and (max-width: {$breakpoint}) {"; ?>
		  		.<?= $modifier ?>\:bg__<?= $color->name() ?> {
		  			--background: <?= implode(',',sscanf($color->color(), "#%02x%02x%02x")) ?>;
		  			background-color: <?= $color->color() ?>;
		  		}
		  		.<?= $modifier ?>\:color__<?= $color->name() ?> {
		  			--col: <?= implode(',',sscanf($color->color(), "#%02x%02x%02x")) ?>;
		  			color: <?= $color->color() ?>;
		  		}
			<?php echo "}"; ?>
		<?php endforeach ?>
	<?php endforeach ?>
	
</style>

