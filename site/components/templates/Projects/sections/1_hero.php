<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div class="z__1 intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__6"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<div class="span__3">
				<div class="flex align__start gap__02 inner-y__02">
					
					<?php if (!empty($filterBy)) : ?>
						<?php 
						// 1. Find the clean display text for the active slug
						$activeText = '';
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
			<div class="flex justify__end">
				<?= snippet('atoms/Text', ['text' => '(Filters)', 'reveal' => true ]) ?>	
			</div>
		</div>
	</div>
</section>
<?php endif ?>