<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo() ]) ?>

<?= snippet('templates/globals/Intro', compact('page')) ?>

<section class="lectures">
	<ul class="grid__2 mobile:grid__1 gap__03">
		<?php foreach (collection('Lectures') as $lecture) : ?>
			<?= snippet('molecules/Lecture/large', compact('lecture')) ?>
		<?php endforeach ?>
	</ul>
</section>

<?php if ($page->specials()->isNotEmpty()) : ?>
	<?php $gallery = $page->specials()->toBlocks()->findBy('type', 'gallery')->images()->toFiles() ?>
	<section class="specials">
		<div class="inner-y__5 grid gap__5">
			<div class="grid inner-x__4 mobile:inner-x__1">
				<div class="grid place__center-start gap__1 wrap-x__10 mobile:wrap-x__0">
					<?= snippet('molecules/Header', ['header' => $page->specials()]) ?>
				</div>
			</div>
		</div>
		<div class="inner-x__4 mobile:inner-x__1 grid__2 gap__2">
			<?php if ($gallery->nth(0)) : ?>
				<div class="grid h__20 mobile:h__10 inner-r__2">
					<?= snippet('atoms/Image', ['img' => $gallery->nth(0), 'parallax' => 2]) ?>
				</div>
			<?php endif ?>
			<?php if ($gallery->nth(1)) : ?>
				<div class="grid h__20 mobile:h__15 wrap-t__4 -wrap-l__2">
					<?= snippet('atoms/Image', ['img' => $gallery->nth(1), 'parallax' => 2]) ?>
				</div>
			<?php endif ?>
			<?php if ($gallery->nth(1)) : ?>
				<div class="span__2 grid place__start-center">
					<div class="grid h__20">
						<?= snippet('atoms/Image', ['img' => $gallery->nth(2), 'parallax' => 2]) ?>
					</div>
				</div>
			<?php endif ?>
		</div>
	</section>
<?php endif ?>
