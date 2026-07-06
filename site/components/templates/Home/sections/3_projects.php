<?php if ($page->featuredProjects()->isNotEmpty()) : ?>
<section class="projects radius" theme="dark" data-carousel>
	<div class="grid__3 gap__2 mobile:grid__1 inner-y__2 inner-b__5 mobile:inner-x__1 ">
		<div data-scroll class="span__2 inner-x__1 ">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['heading']]) ?>
		</div>
		<div class="flex gap__02 justify__end align__end inner-x__1 m">
			<button data-carousel-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1 inner-x__1 " data-carousel-slides >	
			<?php foreach ($page->featuredProjects()->toPages() as $project) : ?>
				<li data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
				<li data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
				<li data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
		<div class="span__3 flex justify__center">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
		</div>
	</div>
</section>
<?php endif ?>