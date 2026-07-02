<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div class="z__1 intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__8"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02">
					<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
				</div>
			</div>
			<div></div>
			<div class="grid gap__1 place__start-end">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="span__4 grid h__100v radius">
			<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['cover']]) ?>
		</div>
	</div>
</section>
<?php endif ?>

<?php if ($page->culture()->toStructure()->isNotEmpty()) : ?>
<section class="culture" theme="invert">
	<div class="grid inner-x__1 inner-t__1 border__top">
		<?php foreach ($page->culture()->toStructure() as $culture) : ?>
			<div class="grid__3 gap__2">
				<div class="flex justify__start">
					<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $culture->label(), 'reveal' => true, 'css' => 'xs font__size__4' ]) ?>
				</div>
				<div class="grid gap__2">
					<?= snippet('atoms/Image', ['img' => $culture->image()->toFile(), 'parallax' => 5, 'reveal' => true, 'css' => 'vh__12']) ?>
				</div>
				<div class="">
					<?= snippet('atoms/Text', ['text' => $culture->text()->inline(), 'reveal' => true]) ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</section>
<?php endif ?>

<section id="opened-positions" class="positions radius inner-t__5" theme="invert">
	<div class="grid inner-x__1">
		<div class="grid__3 gap__2 mobile:grid__1 inner-y__1 mobile:inner-x__1 ">
			<div class="span__2">
				<?= snippet('molecules/Header', ['header' => $page->positions(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex gap__02 justify__end align__end " data-scroll>
				<div class="font__size__3" data-reveal-text>
					(<?= collection('Jobs')->count() ?>)
				</div>
			</div>
		</div>
		<?php if ($page->openPositions()->isNotEmpty()) : ?>
		<div class="grid__3 gap__2 mobile:grid__1 inner-b__5 mobile:inner-x__1 ">
			<ol class="span__3 grid" >	
				<?php foreach ($page->openPositions()->toPages() as $job) : ?>
					<?= snippet('molecules/Job', compact('job')) ?>
				<?php endforeach ?>
			</ol>
		</div>
		<?php endif ?>
	</div>
</section>

<?php if ($page->about()->isNotEmpty()) : ?>
<section class="careers" theme="invert">
	<div class="grid__2 gap__2 place__stretch-stretch inner__1 inner-y__2 inner-b__5">
		<div class="relative grid gap__5 place__start-stretch" data-scroll >
			<div class="grid place__space-between-stretch" data-reveal-text>
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex justify__space-between gap__4 inner-y__1 inner-b__3 border__top">
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="grid inner-l__3" data-scroll >
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['image']]) ?>
		</div>

	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Feed') ?>

<?= snippet('templates/globals/Cta') ?>