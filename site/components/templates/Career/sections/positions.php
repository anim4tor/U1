<?php if (collection('Jobs')->isNotEmpty()) : ?>
<section id="opened-positions" class="positions rounded-radius pt-5" theme="invert">
	<div class="grid px-1">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-2 py-1 px-1 md:px-0">
			<div class="col-span-1 md:col-span-2">
				<?= snippet('molecules/Header', ['header' => $page->positions(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex gap-02 justify-end items-end" data-scroll>
				<div class="font-size-3 text-3xl" data-reveal-text>
					(<?= collection('Jobs')->count() ?>)
				</div>
			</div>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-2 pb-5 px-1 md:px-0">
			<ol class="col-span-1 md:col-span-3 grid" >	
				<?php foreach (collection('Jobs') as $job) : ?>
					<?= snippet('molecules/Job', compact('job')) ?>
				<?php endforeach ?>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>
