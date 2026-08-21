<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro relative z-20" theme="invert" style="--in-delay: 500ms">
	<div class="z-10 relative intro__header pb-2 items-stretch justify-stretch grid grid-cols-1 md:grid-cols-4 gap-2 p-1 pt-10 md:pt-1 gap-2 md:gap-2 relative ">
		<div class="col-span-1 md:col-span-4 h-2"></div>
		<div class="col-span-1 md:col-span-4 py-1 border-b border-white/20 flex justify-between items-end">
			<div class="col-span-1 md:col-span-2">
				<div class="flex items-start gap-02 py-02">
					<?php if (!empty($filterBy)) : ?>
						<?php 
						// 1. Find the clean display text for the active slug
						$activeText = '';
						$tags = array_merge($industries, $spaces);
						foreach ($tags as $tagItem) {
							if ($tagItem['slug'] === $filterBy) {
								$activeText = $tagItem['text'];
								break;
							}
						}
						?>
						<?= snippet('atoms/Heading', [
							'text'   => $activeText, 
							'level'  => 'h1',
							'reveal' => true
						]) ?>

					<?php else : ?>
						<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
					<?php endif ?>
					<?= snippet('atoms/Text', ['text' => '('.$projects->count().')', 'reveal' => true, 'css' => 'font-size-4 text-xs' ]) ?>
				</div>
			</div>
			<div></div>
			<div class="flex justify-end gap-05 items-center" data-scroll>
				<div class="flex items-start gap-05 ">
				<?= snippet('atoms/Button', [ 
			        'url'     => $page, 
			        'label'   => 'All', 
			        'theme'   => 'light', 
			        'reveal'  => true
			    ]) ?>
			    <?= snippet('molecules/Dropdown/filter', [ 'label' => 'Industries', 'options' => $industries ]) ?> 
			    <?= snippet('molecules/Dropdown/filter', [ 'label' => 'Spaces', 'options' => $spaces ]) ?> 
				</div>
			</div>
		</div>
		
	</div>
</section>
<?php endif ?>