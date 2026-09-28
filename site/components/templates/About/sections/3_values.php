<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="process values radius" theme="light">
	<div class="grid__stack gap__2 relative" data-tabs="" >
		<div class="gap__5 grid place__space-between-stretch inner__4" >
			<div class="grid absolute inset__stretch" theme="dark">
				<div data-pane-container class="grid__stack">
					<?php foreach (collection('Values') as $value) : ?>
						<?php if ($img = $value->figure()->toFile()) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="step-<?= $value->indexOf(collection('Values')) ?>" id="trigger-<?= $value->indexOf(collection('Values')) ?>" class="vh__20 grid overlay__bottom">
								<div class="grid w__100v " data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'overlay__harder']) ?>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div class="relative z__1 grid gap__2 color__invert">
				<div class="" data-scroll>
					<div class="flex gap__05 align__center upper font__size__small no__wrap" data-scroll data-reveal="simple"><div><?= t('our-values') ?></div></div>
				</div>
			</div>
			<div class="grid gap__05 place__start-stretch z__1 relative color__invert inner-b__5">
				<div class="grid__<?= collection('Values')->count() ?>" data-scroll >
					<?php foreach (collection('Values') as $value) : ?>
						<div class="grid place__end-start gap__1 inner-y__1">
							<div data-tab="step-<?= $value->indexOf(collection('Values')) ?>" class="flex align__start gap__02" >
								<?= snippet('atoms/Heading', [ 'level' => 'h2', 'text' => $value->value(), 'reveal' => true, 'css' => '', 'node' => 'data-split-ignore' ]) ?>
								<div data-reveal-text="" class="font__size__small" data-split-ignore style="--in-delay: 800ms">(<?= $value->indexOf(collection('Values')) + 1 ?>)</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
				<div class="border__top grid">
					<div data-tabs-progress-line class="progress__line"></div>
				</div>
				<div data-pane-container class="grid__<?= collection('Values')->count() ?>" data-scroll>
					<?php foreach (collection('Values') as $value) : ?>
						<div class="grid gap__1 inner-y__1" data-tab-reveal data-pane="step-<?= $value->indexOf(collection('Values')) ?>" id="pane-text-<?= $value->indexOf(collection('Values')) ?>">
							<p class="" data-reveal-text="lines" data-split-ignore ><?= $value->detail()->inline() ?></p>
						</div>
					<?php endforeach ?>
				</div>
			</div>

		</div>
		
	</div>
</section>
<?php endif ?>