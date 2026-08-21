<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro relative z__2" theme="invert" style="--in-delay: 500ms">
	<div class="z__1 relative intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__2"></div>
		<div class="span__4 inner-y__1 border__bottom flex justify__space-between align__end">
			<div class="span__2">
				<div class="flex align__start  gap__02 inner-y__02">
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
					<?= snippet('atoms/Text', ['text' => '('.$projects->count().')', 'reveal' => true, 'css' => 'font__size__4' ]) ?>
				</div>
			</div>
			<div></div>
			<div class="flex justify__end gap__05 align__center" data-scroll>
				<div class="flex align__start gap__05 ">
				<?= snippet('atoms/Button', [ 
			        'url'     => $page, 
			        'label'   => 'All', 
			        'theme'   => 'light', 
			        'reveal'  => true
			    ]) ?>
			    <?= snippet('molecules/Dropdown/filter', [ 'label' => 'Industries', 'options' => $industries ]) ?> 
			    <?= snippet('molecules/Dropdown/filter', [ 'label' => 'Spaces', 'options' => $spaces ]) ?> 
				</div>
				<!-- <?= snippet('atoms/Text', ['text' => '(Filters)', 'reveal' => true, 'css' => 'upper' ]) ?>	 -->
			</div>
		</div>
		
	</div>
</section>
<?php endif ?>