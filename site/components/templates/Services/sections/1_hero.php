<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="invert" >
	<div class="z__1 intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 inner-x__4 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__6"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<div class="span__3">
				<div class="flex align__start gap__02 inner-y__02">
					<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['label']]) ?>
				</div>
			</div>
			<div class="flex justify__end">
				<?= snippet('atoms/Text', ['text' => '('.collection('Solutions')->count().')', 'reveal' => true, 'css' => 'font__size__small' ]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>