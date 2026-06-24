<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__3 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__8"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<!-- <div data-reveal-text="lines" class="upper s">(<?= $page->title() ?>)</div> -->
			<div class="span__3">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="s" data-reveal-text><?= $page->title() ?></h1>
				</div>
			</div>
			<div data-reveal-text="lines" class="upper flex justify__end">(<?= collection('Solutions')->count() ?>)</div>
		</div>
	</div>
</section>

<?= snippet('templates/globals/News') ?>

<?= snippet('templates/globals/Cta') ?>