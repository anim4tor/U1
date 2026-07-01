<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="span__4 grid place__end-stretch border__bottom inner-y__1">
			<h1 class="m">
				<div data-reveal-text=""><?= $page->title() ?></div>
			</h1>
		</div>
		<div class="span__4 grid__4 place__start-stretch inner-y__1">
			<div></div>
			<div></div>
			<div class="grid gap__2">
				<p class="l lower">Looks like this page took a wrong turn somewhere. Don't worry though - let's get you back on track and find what you're looking for instead.</p>
				<div data-reveal-text="lines" class="upper flex justify__start"><?= snippet('atoms/Button', [ 'url' => page('Home')->url(), 'label' => 'Go back home', 'theme' => 'dark', 'icon' => 'arrow-left', 'node' => 'data-scroll-to']) ?></div>
			</div>
		</div>
	</div>
</section>