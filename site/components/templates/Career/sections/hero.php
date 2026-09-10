<section class="intro radius" theme="dark" style="--in-delay: 500ms">
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['cover'], 'css' => 'overlay__bottom']) ?></div>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 h__5 place__start-start grid__4 border__top inner-t__05">
				<div class="span__2 upper">
					(Kariéra)
				</div>
				<div>
					<p data-reveal-text="lines" class="font__size__4 lower"><?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['text']]) ?></p>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__2 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
			</div>
		</div>
	</div>
</section>