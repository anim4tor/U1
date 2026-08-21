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
				<div class="grid place__center-center span__2 inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'w-['.rand(25,45).'vw] h-['.rand(50,70).'vh] aspect-square']) ?></div>
			<?php else : ?>
				<div class="grid place__center-center inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'w-['.rand(25,45).'vw] h-['.rand(50,70).'vh] aspect-square']) ?></div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>

<?php if ($page->relatedProjects()->isNotEmpty()) : ?>
<section class="projects rounded-radius" theme="dark" >
	<div class="grid grid-cols-1 md:grid-cols-3 gap-1 pb-3 md:px-1" data-carousel>
		<div data-scroll class="col-span-1 md:col-span-2 px-1 pt-2">
			<h2 class="">Related projects</h2>
		</div>
		<div class="flex gap-02 justify-end items-end px-1 text-m">
			<button data-carousel-prev class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="col-span-1 md:col-span-3" data-carousel-scroll>
			<ol class="flex justify-start items-center flex-nowrap gap-1 px-1" data-carousel-slides >	
			<?php foreach ($page->relatedProjects()->toPages() as $project) : ?>
				<li data-slide class="project__wrapper w-[25vw]">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
				<li data-slide class="w-[30vw] flex justify-end">	
					<div class="col-span-1 md:col-span-3 flex justify-center">
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