
<collapsible class="bleed">
	<summary class="p-1" <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>" collapsible-trigger>
		<div class="grid grid-cols-1 md:grid-cols-4 items-center p-2 border-t">
			<div class="col-span-1 md:col-span-3 flex gap-3 justify-start items-center">
				<h3 data-reveal-lines class="pr-5"><?= str_pad($item->indexOf($list) + 1, 2, "0", STR_PAD_LEFT) ?></h3>
				<h3 data-reveal-lines class="pr-5"><?= $item->title() ?></h3>
			</div>
			<div class="flex items-center">
				<div class="label "><?= $item->division() ?></div>
				<div class="plus flex justify-end pl-1" ><div collapsible-icon><span></span><span></span></div></div>
			</div>
		</div>
	</summary>
	<detail collapsible-detail>
		<div class="grid gap-2" data-collapsible-reveal>
			<div class="grid ">	
				<?php foreach ($item->content()->layout()->toLayouts() as $section): ?>
					<?= snippet('molecules/Section', [ 'section' => $section, 'layout' => $page->content()->layout() ] ) ?>
				<?php endforeach ?>
				<div class="grid justify-end p-1">
					<a href="#apply" class="button" data-label="<?= t('job.apply') ?>"><?= t('job.apply') ?></a>
				</div>
			</div>
		</div>
	</detail>
</collapsible>