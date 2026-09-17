<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__3 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="h__10"></div>
		<div class="span__4 grid place__stretch-stretch">
			<div class="span__4 border__top inner-t__05 grid grid__post gap__2 place__space-between-stretch">
				<p class="grid place__start-start font__size__small">
					<span class="upper ">(Blog post)</span>
					<span class="op__4"><?= $page->date()->toDate('Y-m-d') ?></span>
				</p>
				<div class="">
					<h1 class="font__size__2">
						<div data-reveal-text=""><?= $page->title() ?></div>
					</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-x__1">
		<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover h__100v radius grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
		<?php endif ?>
	</div>
</section>

<section class="details" theme="invert">

	<div data-scroll class="place__stretch-stretch grid gap__4 inner__4">
		<div class="grid span__2 gap__2 grid__2">
			<div class=""></div>
			<h2 data-reveal-text="lines" class="font__size__3"><?= $page->excerpt()->inline() ?></h2>
		</div>
		<?php $start = false; ?>
		<?php $end = false; ?>
		<?php foreach ($page->details()->toBlocks() as $block): ?>
			<?php $end = $block->isLast() ? true : false ?>

			<?php if ($block->type() == 'heading' && in_array($block->level(), ['h2','h3'])) : ?>
				<?= $start ? '</div>' : null ?>
				<div id="<?= Str::slug($block->text()->inline()) ?>" class="span__2 grid grid__2 gap__2">	
					<div class="-wrap-r__5 inner-r__10">
						<h3 class="font__size__2"><?= $block->text() ?></h3>
					</div>
					<div class="grid gap__1 inner-r__10">
				<?php $start = true ?>
			<?php else : ?>
				<div class="lower">
					<?php snippet('blocks/'.$block->type(), ['block' => $block]) ?>
				</div>
			<?php endif; ?>

			<?= $start && $end ? '</div></div>' : null ?>
		<?php endforeach ?>
	</div>
</section>

<?= snippet('templates/globals/Feed/related') ?>
<?= snippet('templates/globals/Cta') ?>