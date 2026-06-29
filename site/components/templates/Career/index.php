<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__2 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__8"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="wrap xs" data-reveal-text>We are constantly moving forward</h1>
				</div>
			</div>
			<div></div>
			<div data-reveal-text="lines" class="upper flex justify__end"><?= snippet('atoms/Button', [ 'url' => '#opened-positions', 'label' => 'Open positions ('.collection('Jobs')->count().')', 'theme' => 'invert', 'icon' => 'arrow-down', 'node' => 'data-scroll-to']) ?></div>
		</div>
	</div>
</section>

<section>
	<div class="grid inner-x__1" theme="invert">
		<div class="grid__3 gap__2 h__100v inner__1 relative ">
			<div class="absolute inset__stretch radius">
				<?= snippet('atoms/Image', ['img' => page('About')->image(), 'parallax' => 5, 'reveal' => false, 'css' => 'overlay__bottom radius']) ?>
			</div>
			<div></div>
			<div></div>
			<div class="grid place__end-start color__invert relative " >
				<div class="grid sticky bottom__1">
					<!-- <p class="l">We have a vision and our company culture is buzzing. Are we going to be a great match?</p> -->
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about" theme="invert">

	<div class="grid inner-x__1 ">
		<div class="grid__3 gap__2 inner-t__1 border__top">
			<div class="flex justify__start " data-scroll>
				<h3 class="xs " data-reveal-text="lines">Our culture</h3>
			</div>
			<div class="grid gap__2">
				<?= snippet('atoms/Image', ['img' => page('About')->image(), 'parallax' => 3, 'reveal' => false, 'css' => 'vh__12 img__radius']) ?>
			</div>
			<div class="">
				<p>Without the right people, we couldn't function. Do you want to be involved in big projects, take responsibility and work in offices where you feel at home? Let us know about you.</p>
			</div>
		</div>
		<div class="grid__3 gap__2">
			<div class="flex justify__start " data-scroll>
				<h3 class="xs sticky top__10" data-reveal-text="lines">Our culture</h3>
			</div>
			<div class="grid gap__2">
				<?= snippet('atoms/Image', ['img' => page('About')->image(), 'parallax' => 3, 'reveal' => false, 'css' => 'vh__12 img__radius']) ?>
			</div>
			<div class="">
				<p>Without the right people, we couldn't function. Do you want to be involved in big projects, take responsibility and work in offices where you feel at home? Let us know about you.</p>
			</div>
		</div>
		<div class="grid__3 gap__2">
			<div class="flex justify__start " data-scroll>
				<h3 class="xs sticky top__10" data-reveal-text="lines">Our culture</h3>
			</div>
			<div class="grid gap__2">
				<?= snippet('atoms/Image', ['img' => page('About')->image(), 'parallax' => 3, 'reveal' => false, 'css' => 'vh__12 img__radius']) ?>
			</div>
			<div class="">
				<p>Without the right people, we couldn't function. Do you want to be involved in big projects, take responsibility and work in offices where you feel at home? Let us know about you.</p>
			</div>
		</div>
	</div>
</section>

<section id="opened-positions" class="positions radius inner-t__5" theme="invert">
	<div class="grid inner-x__1">
		<div class="grid__3 gap__2 mobile:grid__1 inner-y__1 mobile:inner-x__1 ">
			<div data-scroll class="span__2">
				<h2 class="l" data-reveal-text>
					Opened <br>positions
				</h2>
			</div>

			<div class="flex gap__02 justify__end align__end " data-scroll>
				<div class="font__size__3" data-reveal-text>
					(<?= collection('Jobs')->count() ?>)
				</div>
			</div>
		</div>
		<div class="grid__3 gap__2 mobile:grid__1 inner-b__5 mobile:inner-x__1 ">
			<ul class="span__3 grid" >	
				<?php foreach (collection('Jobs') as $job) : ?>
					<?= snippet('molecules/Job', compact('job')) ?>
					<?= snippet('molecules/Job', compact('job')) ?>
					<?= snippet('molecules/Job', compact('job')) ?>
					<?= snippet('molecules/Job', compact('job')) ?>
				<?php endforeach ?>

			</ul>
		</div>
	</div>
</section>

<?php if (collection('Jobs')->isNotEmpty()) : ?>
<section class="careers" theme="invert">
	<div class="grid__2 gap__2 place__stretch-stretch inner__1 inner-y__2 inner-b__5">
		<div class="relative grid gap__5 place__start-stretch" data-scroll >
			<div class="grid place__space-between-stretch" data-reveal-text>
				<h2 class="s">We create the identity of interiors. As designers and experienced consultants.</h2>
			</div>
			<div class="flex justify__space-between gap__4 inner-y__1 inner-b__3 border__top">
				<p class="l lower">Twenty-five years of refined expertise, distilled into a comprehensive suite of architectural and design solutions creating experiences that amplify the joy felt in shared human moments.</p>
				<?= snippet('atoms/Button', [ 'url' => page('About')->url(), 'label' => 'About us', 'theme' => 'invert', 'icon' => 'arrow-right']) ?>
			</div>
		</div>
		<div class="grid inner-l__3">
			<?= snippet('atoms/Image', ['img' => page('About')->image(), 'parallax' => 5, 'reveal' => false, 'css' => 'radius']) ?>
		</div>

	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Feed') ?>

<?= snippet('templates/globals/Cta') ?>