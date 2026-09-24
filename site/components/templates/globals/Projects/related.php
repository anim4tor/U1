<?php
// Normalize $projects input (supports Kirby Field, Pages Collection, or Array)
if (isset($projects)) {
    if ($projects instanceof \Kirby\Cms\Field) {
        $projects = $projects->toPages();
    }
} else {
    $projects = isset($page) && $page->relatedProjects()->isNotEmpty() ? $page->relatedProjects()->toPages() : null;
}

$title   = $title  ?? 'Související projekty';
$theme   = $theme  ?? 'dark';
$hasProj = $projects && (is_countable($projects) ? count($projects) > 0 : $projects->isNotEmpty());

// Button handling
if (!isset($button)) {
    $button = isset($page) && $page->projects()->isNotEmpty() 
        ? snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']], true) 
        : null;
}
?>

<?php if ($hasProj) : ?>
<section class="projects radius" theme="<?= $theme ?>">
	<div class="grid__3 gap-x__1 gap-y__2 mobile:grid__1 inner__4 mobile:inner-x__1 " data-carousel>
		<div data-scroll class="flex align__start gap__01 span__2 relative">
			<div class="absolute -left__03 w__03 h__03 bg__acc"></div>
			<h2 class=""><?= $title ?></h2>
		</div>
		<div class="flex gap__02 justify__end align__end ">
			<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1" data-carousel-slides>	
			<?php foreach ($projects as $project) : ?>
				<li data-slide class="project__wrapper vw__5">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
			<?php if ($button) : ?>
				<li data-slide class="vw__6 flex justify__end">	
					<div class="span__3 flex justify__center">
						<?= $button ?>
					</div>
				</li>
			<?php endif ?>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>
