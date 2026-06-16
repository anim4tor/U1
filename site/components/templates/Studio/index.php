<?php snippet('templates/globals/Intro', compact('page'), slots: true) ?>
  <?php slot('title') ?>
    <h1 data-reveal-text class="xl bolder"><?= $page->customTitle()->isNotEmpty() ? $page->customTitle() : $page->title() ?></h1>
  <?php endslot() ?>
  <?php slot('subtitle') ?>
  	<div class="inner-x__4 mobile:inner-x__0"><h1 data-reveal-text class="xl bolder"><?= $page->subtitle() ?></h1></div>
  <?php endslot() ?>
  <?php slot('cover') ?><?php endslot() ?>
<?php endsnippet() ?>

<section class="about">
	<div class="grid__5 mobile:grid__1">
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="grid span__3 mobile:span__1 mobile:h__20" >
				<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?>
			</div>
		<?php endif ?>
		<div class="grid span__2 mobile:span__1 h__100v mobile:h__auto place__center-start gap__3 inner__4 mobile:inner-x__1">
			<?= snippet('molecules/Header', ['header' => $page->intro()]) ?>
		</div>
	</div>
</section>

<section class="team">
	<div class="inner-x__1 inner-y__5 grid gap__3">
		<?php if ($page->team()->isNotEmpty()) : ?>
		<div class="grid__3">
			<div class="span__2 grid gap__1">
				<?= snippet('molecules/Header', ['header' => $page->team()]) ?>
			</div>
		</div>
		<?php endif ?>
		<ul class="grid__4 mobile:grid__1 gap__1">
			<?php foreach (collection('Team') as $instructor) : ?>
				<li><?= snippet('molecules/Instructor', compact('instructor')) ?></li>
			<?php endforeach ?>
		</ul>
	</div>
</section>

<?= snippet('templates/globals/Cta') ?>