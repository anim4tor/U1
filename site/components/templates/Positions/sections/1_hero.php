<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro relative z__2" theme="invert" style="--in-delay: 500ms">
	<div class="z__1 relative intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="span__4 h__2"></div>
		<div class="span__4 inner-y__1 border__bottom flex justify__space-between align__end">
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02">
					<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
					<?= snippet('atoms/Text', ['text' => '('.$jobs->count().')', 'reveal' => true, 'css' => 'font__size__small']) ?>
				</div>
			</div>
			<div></div>
			<div></div>
		</div>
	</div>
</section>
<?php endif ?>
