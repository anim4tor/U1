
<collapsible class="bleed">
	<summary class="wrap__1" <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>" collapsible-trigger>
		<div class="grid__4 grid__middle inner__2 border__top">
			<div class="span__3 flex gap__3 flex__start flex__middle">
				<h3 data-reveal-lines class="wrap__right__5"><?= str_pad($item->indexOf($list) + 1, 2, "0", STR_PAD_LEFT) ?></h3>
				<h3 data-reveal-lines class="span__5 wrap__right__5"><?= $item->title() ?></h3>
			</div>
			<div class="flex flex__middle">
				<div class="label "><?= $item->division() ?></div>
				<div class="plus flex flex__end wrap__left__1" ><div collapsible-icon><span></span><span></span></div></div>
			</div>
		</div>
	</summary>
	<detail collapsible-detail>
		<div class="grid gap__2" data-collapsible-reveal>
			<div class="grid ">	
				<?php foreach ($item->content()->layout()->toLayouts() as $section): ?>
					<?= snippet('molecules/Section', [ 'section' => $section, 'layout' => $page->content()->layout() ] ) ?>
				<?php endforeach ?>
				<div class="grid grid__end inner__1 wrap__1">
					<a href="#apply" class="button" data-label="<?= t('job.apply') ?>"><?= t('job.apply') ?></a>
				</div>
			</div>
		</div>
	</detail>
</collapsible>