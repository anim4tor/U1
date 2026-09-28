<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="about radius" theme="invert">
	<div class="grid__4 gap__2 place__stretch-stretch inner__4" data-tabs="default">
		<div class="hidden absolute">
			<?php foreach (collection('Values') as $value) : ?>
				<div data-tab="value-<?= $value->indexOf(collection('Values')) ?>"></div>
			<?php endforeach ?>
		</div>

		<div class="relative grid gap__5 place__space-between-start" data-scroll>
			<div class="grid place__start-stretch" data-reveal-text>
				<div data-scroll class="flex align__start gap__01 span__2">
					<?= snippet('atoms/Label', ['text' => t('our-values', 'Naše hodnoty'), 'reveal' => true]) ?>
				</div>
			</div>
			
			<div class="grid gap__1 place__start-start">
				<div data-pane-container class="grid__stack place__end-start" data-scroll>
					<?php foreach (collection('Values') as $value) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="value-<?= $value->indexOf(collection('Values')) ?>" id="value-<?= $value->indexOf(collection('Values')) ?>" class="grid gap__1 place__start-start">
						<div class="flex align__center gap__02">
							<h3><?= $value->value()->inline() ?></h3>
							<span class="font__size__small op__7">(<?= $value->indexOf(collection('Values')) + 1 ?>)</span>
						</div>
						<p><?= $value->detail()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
				<div class="flex gap__02 justify__start align__end">
					<button data-tab-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
					<button data-tab-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
				</div>
			</div>
		</div>
		<div></div>
		<div data-pane-container class="span__2 grid__stack" data-scroll>
			<?php foreach (collection('Values') as $value) : ?>
				<?php if ($img = $value->figure()->toFile()) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="value-<?= $value->indexOf(collection('Values')) ?>" id="value-img-<?= $value->indexOf(collection('Values')) ?>" class="grid">
						<div class="grid" data-reveal-image>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'aspect__5/4']) ?>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>

	</div>
</section>
<?php endif ?>