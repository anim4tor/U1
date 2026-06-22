<?php snippet('templates/globals/Intro', compact('page'), slots: true) ?>
  <?php slot('subtitle') ?>
  	<div class="intro__subtitle flex align__end gap__05 inner-r__2"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-bottom-left.svg') ?></span><p class="font__size__3 mobile:xs" data-reveal-text="words"><?= $page->subtitle() ?></p></div>
  <?php endslot() ?>
<?php endsnippet() ?>

<section class="pricelist">
	<div class="inner-y__5 inner-x__12 mobile:inner-x__1 grid gap__3">

		<?php if ($page->single()->isNotEmpty()) : ?>
			<div class="grid" data-tabs>
				<?php 
					$tabs = [];
					foreach ($page->single()->toStructure() as $item):
						$tabs[$item->duration()->value()][] = $item;
					endforeach;
				?>
				<div class="flex mobile:grid__1 gap__1 align__center justify__space-between inner-y__1 border__bottom">
					<h2 class=""><?= t('pricing-single') ?></h2>
					<div class="flex gap__02">
						<?php foreach ($tabs as $duration => $tab): ?>
							<button data-tab class="button upper --small" theme="ghost" aria-label="<?= $duration ?> minutes"><?= $duration ?> min</button>
						<?php endforeach ?>
					</div>
				</div>
				<div data-pane-container>
					<?php foreach ($tabs as $items): ?>
					<ul class="class__list grid" data-pane>
						<?php foreach ($items as $item): ?>
						  <li class="inner-y__03 flex align__center justify__space-between border__bottom"><p class=""><?= $item->label() ?></p><p class="l bolder"><?= $item->price() ?> Kč</p></li>
						<?php endforeach ?>
					</ul>
					<?php endforeach ?>
				</div>
			</div>
		<?php endif ?>

		<div class="grid" data-tabs>
			<?php if ($page->passes()->isNotEmpty()) : ?>
				<?php 
					$tabs = [];
					foreach ($page->passes()->toStructure() as $item):
						$tabs[$item->duration()->value()][] = $item;
					endforeach;
				?>
				<div class="flex mobile:grid__1 gap__1 align__center justify__space-between inner-y__1 border__bottom">
					<h2 class=""><?= t('pricing-passes') ?></h2>
					<div class="flex gap__02">
						<?php foreach ($tabs as $duration => $tab): ?>
							<button data-tab class="button upper --small" theme="ghost" aria-label="<?= $duration ?> minutes"><?= $duration ?> min</button>
						<?php endforeach ?>
					</div>
				</div>
				<div data-pane-container>
					<?php foreach ($tabs as $items): ?>
					<ul class="class__list grid" data-pane>
						<?php foreach ($items as $item): ?>
						  <li class="inner-y__03 flex align__center justify__space-between border__bottom"><p class=""><?= $item->label() ?></p><p class="l bolder"><?= $item->price() ?> Kč</p></li>
						<?php endforeach ?>
					</ul>
					<?php endforeach ?>
				</div>
				<?php if ($page->credit()->isNotEmpty()) : ?>
						<div class="grid gap__1 inner-t__2">
							<?= snippet('molecules/Header', ['header' => $page->credit()]) ?>
						</div>
				<?php endif ?>
			<?php endif ?>
		</div>

		<div class="grid">
			<?php if ($page->membership()->isNotEmpty()) : ?>
				<div class="flex align__center justify__start inner-y__1 border__bottom">
					<h2 class=""><?= t('pricing-membership') ?></h2>
				</div>
				<ul class="class__list grid">
					<?php foreach ($page->membership()->toStructure() as $item): ?>
					  <li class="inner-y__03 flex align__center justify__space-between border__bottom"><p class=""><?= $item->label() ?></p><p class="l bolder"><?= $item->price() ?> Kč</p></li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
			<?php if ($page->benefits()->isNotEmpty()) : ?>
					<div class="grid gap__1 inner-t__2">
						<?= snippet('molecules/Header', ['header' => $page->benefits()]) ?>
					</div>
			<?php endif ?>
		</div>
		
	</div>
</section>