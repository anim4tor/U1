<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo() ]) ?>

<?php snippet('templates/globals/Intro', compact('page'), slots: true) ?>
  <?php slot('cover') ?><?php endslot() ?>
<?php endsnippet() ?>

<section class="contact">
	<div class="grid__5 mobile:grid__1">
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="grid span__3 mobile:h__100v" >
				<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-stretch span__2 gap__0 inner__2 mobile:inner-x__1 inner-y__4">
			<?php if ($page->intro()->isNotEmpty()) : ?>
				<?= snippet('molecules/Header', ['header' => $page->intro()]) ?>
			<?php endif ?>
			<div class="grid place__start-start gap__05 inner-y__1" data-scroll data-reveal-text="lines">
				<h3 class="xs bolder"><?= t('contact') ?></h3>
				<div class="grid gap__02">
					<p class="m"><a href="mailto: <?= $site->contactEmail() ?>"><?= $site->contactEmail() ?></a></p>
					<div class="flex align__end gap__02">
						<p class="m"><a href="tel: <?= $site->contactPhone() ?>"><?= $site->contactPhone() ?></a></p>
					</div>
					<p class="s"><?= $site->contactPhoneNote() ?></p>
				</div>
			</div>
			<div class="grid place__start-start gap__05 inner-y__1 border__top" data-scroll data-reveal-text="lines">
				<h3 class="xs bolder"><?= t('studio') ?></h3>
				<div class="grid gap__02">
					<p class="m"><a href="<?= $site->contactMapUrl() ?>" target="_blank"><?= $site->contactAddress() ?></a></p>
					<p class="s"><?= $site->contactAddressNote() ?></p>
				</div>
			</div>
			<div class="grid place__start-start gap__05 inner-y__1 border__top" data-scroll data-reveal-text="lines">
				<h3 class="xs bolder"><?= t('opening-hours') ?></h3>
				<p class=""><?= $site->contactOpening() ?></p>
			</div>
		</div>
	</div>
</section>
