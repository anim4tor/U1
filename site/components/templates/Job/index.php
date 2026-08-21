<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__3 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="h__10"></div>
		<div class="span__4 grid place__stretch-stretch">
			<div class="span__4 border__top inner-t__05 grid grid__post gap__2 ">
				<div class="grid__2 gap__2">	
					<a href="<?= $page->parent()->url() ?>" data-reveal-text="lines" class="upper text-s">(Open positions)</a>
					<span data-reveal-text="lines" class="upper text-s"><?= $page->location() ?></span>
				</div>
				<div class="">
					<h1 class="font__size__2 text-xs">
						<div data-reveal-text=""><?= $page->title() ?></div>
					</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-x__1 grid">
		<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover h__100v radius grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
		<?php endif ?>
	</div>
</section>

<section class="details" theme="invert" data-contact-scroll-toggle="contact">

	<div data-scroll class="place__stretch-stretch grid gap__2 inner-x__1 inner-t__2 inner-b__2">
		<div class="grid span__2 gap__2 grid__post">
			<div class=""></div>
			<h2 data-reveal-text="lines" class="font__size__4 text-m"><?= $page->excerpt()->inline() ?></h2>
		</div>
		<div class="span__2 grid grid__post gap__2 inner-y__1 border__top">	
			<div class="-wrap-r__5 inner-r__10">
				<h3 class="font__size__5">Details</h3>
			</div>
			<div class="grid gap__1 inner-r__10">
				<?= $page->details() ?>
			</div>	
		</div>
		<div class="span__2 grid grid__post gap__2 inner-y__1 border__top">	
			<div class="-wrap-r__5 inner-r__10">
				<h3 class="font__size__5">Description</h3>
			</div>
			<div class="grid gap__1 inner-r__10">
				<?= $page->description() ?>
			</div>	
		</div>
		<div class="span__2 grid grid__post gap__2 inner-y__1 border__top">	
			<div class="-wrap-r__5 inner-r__10">
				<h3 class="font__size__5">Requirements</h3>
			</div>
			<div class="grid gap__1 inner-r__10">
				<?= $page->requirements() ?>
			</div>	
		</div>
		<div class="span__2 grid grid__post gap__2 inner-y__1 border__top">	
			<div class="-wrap-r__5 inner-r__10">
				<h3 class="font__size__5">Benefits</h3>
			</div>
			<div class="grid gap__1 inner-r__10">
				<?= $page->benefits() ?>
			</div>	
		</div>
	</div>
</section>

<section class="details" theme="invert">

	<div data-scroll class="place__stretch-stretch grid gap__2 inner-x__1 inner-t__2 inner-b__5">
		<div class="grid span__2 gap__2 inner-y__1 grid__post border__top">
			<div class=""></div>
			<div class="grid place__start-start gap__1 inner-r__10">
				<h2 data-reveal-text="lines" class="font__size__4 text-m">Ready to get started? Just say it!</h2>
				<?= snippet('atoms/Button', [ 'label' => 'Apply for job', 'theme' => 'dark', 'icon' => 'arrow-right', 'node' => 'data-contact-toggle="inquiry"']) ?>
			</div>
		</div>
	</div>
</section>
