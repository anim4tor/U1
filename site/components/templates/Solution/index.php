<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 h__5 place__start-start grid__4 border__top inner-t__05">
				<div class="span__2">
					<a href="<?= $page->parent()->url() ?>" data-reveal-text="lines" class="upper">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</a>
				</div>
				<div>
					<p data-reveal-text="lines" class="font__size__4 text-s lower"><?= $page->excerpt()->or($page->intro())->inline() ?></p>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<h1 class="">
					<div data-reveal-text=""><?= $page->title() ?></div>
				</h1>
			</div>
		</div>
	</div>
</section>

<section class="about" theme="invert">
	<div data-scroll class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h2 data-reveal-text="lines" class="font__size__4"><?= $page->intro()->inline() ?></h2>
		</div>
		
	</div>
	<div data-scroll class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div></div>
		<div class=" grid place__start-start gap__3 mobile:inner-x__0">
			<p data-reveal-text="lines" class=""><?= $page->details()->inline() ?></p>
		</div>
		
	</div>
</section>

<section class="gallery" theme="invert">
	<!-- randomizace -->
	<div class="grid__4 gap__2 gap-y__4 inner__1 inner-x__3 inner-b__5">
		<?php foreach ($page->gallery()->toFiles() as $image) : ?>
			<?php if($image->orientation() == "landscape") : ?>
				<div class="grid place__center-center span__2 inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'vw__'.rand(5,9) . ' vh__'.rand(10,14) . ' aspect__1/1']) ?></div>
			<?php else : ?>
				<div class="grid place__center-center inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'vw__'.rand(5,9) . ' vh__'.rand(10,14) . ' aspect__1/1']) ?></div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>

<?php if ($page->relatedProjects()->isNotEmpty()) : ?>
<section class="projects radius" theme="dark" >
	<div class="grid__3 gap__1 mobile:grid__1 inner-b__3 mobile:inner-x__1 " data-carousel>
		<div data-scroll class="span__2 inner-x__1 inner-t__2 inner-b__">
			<h2 class="">Related projects</h2>
		</div>
		<div class="flex gap__02 justify__end align__end inner-x__1 text-m">
			<button data-carousel-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1 inner-x__1 " data-carousel-slides >	
			<?php foreach ($page->relatedProjects()->toPages() as $project) : ?>
				<li data-slide class="project__wrapper vw__5">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
				<li data-slide class="vw__6 flex justify__end">	
					<div class="span__3 flex justify__center">
						<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
					</div>
				</li>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Feed/related') ?>
<?= snippet('templates/globals/Cta') ?>