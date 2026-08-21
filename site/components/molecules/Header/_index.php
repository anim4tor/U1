<div class="grid gap__1 " data-scroll>
	<?php if ($header->label()->isNotEmpty()): ?>
		<p class="op__6" data-reveal-text="words"><?= $header->label()->inline() ?></p>
	<?php endif ?>
	<?php if ($imgs = $header->image()->toFiles()): ?>
		<?php foreach ($imgs as $img) : ?>
			<figure data-reveal class=""><?= snippet('atoms/Image', compact('img')) ?></figure>
		<?php endforeach ?>
	<?php endif ?>
	<?php if ($img = $header->image()->toFile()): ?>
		<figure data-reveal><?= snippet('atoms/Image', compact('img')) ?></figure>
	<?php endif ?>
	<?php if ($header->heading()->isNotEmpty()): ?>
		<div data-reveal-text="words" class="<?= $header->headingSize() ?>" ><?= $header->heading() ?></div>
	<?php endif ?>
	<?php if ($header->text()->isNotEmpty()): ?>
		<p data-reveal-text="words"><?= $header->text()->inline() ?></p>
	<?php endif ?>
	<div class="flex gap__02">
		<?php if ($header->link()->isNotEmpty()): ?>
			<?php $button = $header->link()->toObject(); ?>
			<div href="<?= $button->link()->toUrl() ?>" data-reveal class="button circle bg__light" data-label="<?= $button->label() ?>"><span class="icon color__red z__1"><?= svg('public/assets/images/ui/ui_arrow_right.svg') ?></span></div>
		<?php endif ?>
	</div>
</div>
