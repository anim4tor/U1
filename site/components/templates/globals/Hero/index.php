<?php
// Normalize hero input (podporuje Kirby Field i Blocks kolekci)
$hero ??= isset($page) ? $page->hero() : null;
$hasHero = false;
if ($hero instanceof \Kirby\Cms\Field) {
    $hasHero = $hero->toBlocks()->isNotEmpty();
} elseif ($hero instanceof \Kirby\Cms\Blocks) {
    $hasHero = $hero->isNotEmpty();
}
?>
<?php if ($hasHero) : ?>
<section class="intro radius" theme="dark" style="--in-delay: 500ms">
	<div class="intro__cover absolute inset__stretch grid overlay__harder" data-scroll><?= snippet('molecules/Header', ['header' => $hero, 'type' => ['cover']]) ?></div>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 h__5 place__start-start grid__4 gap__2 border__top inner-t__05">
				<div class="span__2 upper font__size__small">
					(<?= t('template.' . $page->intendedTemplate()->name(), t($page->intendedTemplate()->name(), $page->title()->value())) ?>)
				</div>
				<div class="grid gap__1 place__start-start span__2">
					<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['text', 'button']]) ?>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__2 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['heading']]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>