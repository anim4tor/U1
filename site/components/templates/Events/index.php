<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo() ]) ?>

<?= snippet('templates/globals/Intro', compact('page')) ?>

<?php if ($featured = collection('Events')->first()) : ?>
	<?= snippet('molecules/Event/featured', compact('featured')) ?>
<?php endif ?>

<?php if (collection('Events')) : ?>
	<section class="evetlist">
		<div class="inner-y__5 grid gap__5">
			<div class="grid inner-x__4 mobile:inner-x__1">
				<div class="flex align__center justify__space-between inner-y__1 border__bottom">
					<h2 class="font__size__3 lighter"><?= t('upcoming-events') ?></h2>
					<?= snippet('atoms/Button', ['url' => page('kontakt')->url(), 'label' => t('host-own-event'), 'theme' => 'invert']) ?>
				</div>
				<ul class="class__list grid">
					<?php foreach (collection('Events') as $event) : ?>
						<?= snippet('molecules/Event', compact('event')) ?>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
	</section>
<?php endif ?>