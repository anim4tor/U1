<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 border__bottom h__8"></div>
		<div class="span__4 inner-t__05 grid__4 place__start-start">
			<!-- <div data-reveal-text="lines" class="upper s">(<?= $page->title() ?>)</div> -->
			<div class="span__3">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="s" data-reveal-text>All work</h1>
					<div data-reveal-text="" class="-wrap-t__05 font__size__4" data-split-ignore style="--in-delay: 800ms">(<?= collection('Projects')->count()*2 ?>)</div>
				</div>
			</div>
			<div data-reveal-text="lines" class="upper s flex justify__end">(Filters)</div>
			<div class="span__2"></div>
			<div class="span__2 grid__2 gap__2 relative place__end-stretch mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<!-- <div data-reveal-text="lines" class="upper s"><?= $page->client() ?></div> -->
				<!-- <div data-reveal-text="lines" class="upper s"><?= $page->space() ?></div> -->
				<div data-reveal-text="lines" class="upper s"><?= $page->date()->toDate('Y') ?></div>
				<div data-reveal-text="lines" class="upper s"><?= $page->place() ?></div>
			</div>
		</div>
	</div>
</section>

<section class="list" theme="invert">
	<ul class="grid__2 gap__1 inner__1 inner-b__5">
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
	</ul>
</section>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>