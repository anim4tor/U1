<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if ($page->life()->isNotEmpty()) : ?>
<section class="process radius" theme="light">
	<div class="grid__stack gap__2 relative" data-tabs="" >
		<div class="gap__5 grid place__space-between-stretch inner__4" >
			<div class="grid absolute inset__stretch" theme="dark">
				<div data-pane-container class="grid__stack">
					<?php foreach ($page->life()->toStructure() as $life) : ?>
						<?php if ($img = $life->image()->toFile()) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="step-<?= $life->indexOf($page->life()->toStructure()) ?>" id="trigger-<?= $life->indexOf($page->life()->toStructure()) ?>" class="vh__20 grid overlay__bottom">
								<div class="grid w__100v " data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'overlay__bottom']) ?>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div class="relative z__1 grid gap__2 color__invert">
				<div class="" data-scroll>
					<div class="flex gap__05 align__center upper font__size__small no__wrap" data-scroll ><div class="w__05 h__05 bg__invert"></div><div data-reveal-text>Život s U1</div></div>
				</div>
			</div>
			<!-- <div class="relative flex inner-x__1 z__1 color__invert">
				<?= snippet('atoms/Text', ['text' => '(Our process)', 'reveal' => true, 'css' => 'upper' ]) ?>	
			</div> -->
			<div class="grid gap__05 place__start-stretch z__1 relative color__invert inner-b__5">
				<div class="grid__4 " data-scroll >
					<?php foreach ($page->life()->toStructure() as $life) : ?>
						<div class="grid place__end-start gap__1 inner-y__1">
							<div data-tab="step-<?= $life->indexOf($page->life()->toStructure())?>" class="flex align__start gap__02" >
								<?= snippet('atoms/Heading', [ 'level' => 'h2', 'text' => $life->title(), 'reveal' => true, 'css' => '', 'node' => 'data-split-ignore' ]) ?>
								<div data-reveal-text="" class="font__size__small" data-split-ignore style="--in-delay: 800ms">(<?= $life->indexOf($page->life()->toStructure()) ?>)</div>
							</div>
						</div>

					<?php endforeach ?>
				</div>
				<div class="border__top grid">
					<div data-tabs-progress-line class="progress__line"></div>
				</div>
				<div data-pane-container class="grid__4" data-scroll>
					<?php foreach ($page->life()->toStructure() as $life) : ?>
						<div class="grid gap__1 inner-y__1" data-tab-reveal data-pane="step-<?= $life->indexOf($page->life()->toStructure()) ?>" id="trigger-<?= $life->indexOf($page->life()->toStructure()) ?>">
							<p class="" data-reveal-text="lines" data-split-ignore ><?= $life->text()->inline() ?></p>
						</div>

					<?php endforeach ?>
				</div>
			</div>

		</div>
		
		
	</div>
</section>
<?php endif ?>