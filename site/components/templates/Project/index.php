<?php
	$usedImages = [];
	if ($cover = $page->cover()->toFile()) {
		$usedImages[] = $cover->id();
	}
?>

<?= snippet('templates/globals/Hero/project') ?>

<section class="about" theme="invert">
	<div data-scroll class="grid__4 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1 ">
		<div class="span__2">
			<?= snippet('atoms/Label', ['text' => t('about-project')]) ?>
		</div>
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h3 data-reveal-text="lines" class="font__size__3"><?= $page->intro()->inline() ?></h3>
		</div>
		<div></div>
		<div></div>
		<div data-scroll class="grid span__2 mobile:grid__1">
			<?php
			$specs = [
				'date' => 'Rok',
				'client' => 'Klient',
				'place' => 'Lokalita',
				'industry' => 'Odvětví',
				'space' => 'Typ prostoru',
				'production' => 'Výroba',
				'size' => 'Velikost',
				'team' => 'Realizace',
				'photo'   => 'Fotografie',
			];
			?>
			<?php foreach ($specs as $field => $label): ?>
				<?php $val = $page->$field(); ?>
				<?php if ($val->isNotEmpty()): ?>
					<div class="grid__2 gap__2 border__top inner-y__05">
						<?= snippet('atoms/Label', ['text' => $label]) ?>
						<p class="font__size__default"><?= $field != 'date' ? $val : $val->toDate('Y') ?></p>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php 
			$customItems = $page->customInfo()->toStructure();
			if ($customItems->isNotEmpty()): 
				foreach ($customItems as $item): 
					if ($item->value()->isNotEmpty()): ?>
						<div class="grid__2 gap__2 border__top inner-y__05">
							<?= snippet('atoms/Label', ['text' => $item->label()->isNotEmpty() ? $item->label() : $item->title()]) ?>
							<p class="font__size__default"><?= $item->value() ?></p>
						</div>
					<?php endif; 
				endforeach; 
			else: 
				if ($page->concept()->isNotEmpty()): ?>
					<div class="grid__2 gap__2 border__top inner-y__05">
						<?= snippet('atoms/Label', ['text' => 'Koncept']) ?>
						<p class="font__size__default"><?= $page->concept() ?></p>
					</div>
				<?php endif; ?>
				<?php if ($page->collabs()->isNotEmpty()): ?>
					<div class="grid__2 gap__2 border__top inner-y__05">
						<?= snippet('atoms/Label', ['text' => 'Spolupráce']) ?>
						<p class="font__size__default"><?= $page->collabs() ?></p>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</div>
	</div>
</section>

<?php if ($page->before()->isNotEmpty() && $page->after()->isNotEmpty()): ?>
<?php
	$before = $page->before()->toFile();
	$after = $page->after()->toFile(); 
?>
<section theme="invert">
	<div class="grid inner__4" data-scroll>
		<div class="before-after-container vh__20 img__radius" style="--position: 41.75%;">
		  <div class="image-container before-image">
		  	<?= snippet('atoms/Image', ['img' => $before, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__20']) ?>
		  	<?php if ($before) { $usedImages[] = $before->id(); } ?>
		  </div>

		  <div class="image-container after-image">
		  	<?= snippet('atoms/Image', ['img' => $after, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__20']) ?>
		  	<?php if ($after) { $usedImages[] = $after->id(); } ?>
		  </div>

		  <input 
		    type="range" 
		    min="0" 
		    max="100" 
		    value="50" 
		    class="slider-input" 
		    aria-label="Before/after percentage slider"
		  >
		  <div class="slider-line" aria-hidden="true"></div>
		</div>
		<script type="text/javascript">
			document.querySelectorAll('.before-after-container').forEach(container => {
			  const slider = container.querySelector('.slider-input');
			  slider.addEventListener('input', (e) => {
			    container.style.setProperty('--position', `${e.target.value}%`);
			  });
			});
		</script>
	</div>
</section>
<?php endif; ?>

<section class="details" theme="invert">
	<div data-scroll class="place__stretch-stretch grid gap__4 inner__4">
		<?= snippet('molecules/Blocks', [ 'blocks' => $page->details()->toBlocks() ])?>
		<?php foreach ($page->details()->toBlocks() as $block) {
		    if ($block->type() === 'image' && $blockImg = $block->image()->toFile()) {
		        $usedImages[] = $blockImg->id();
		    }
		    if ($block->type() === 'gallery') {
		        foreach ($block->images()->toFiles() as $galleryImg) {
		        	if ($galleryImg) { $usedImages[] = $galleryImg->id(); }
		        }
		    }
		} ?>
	</div>
</section>

<?php if($page->password()->isNotEmpty()) : ?>
<?php if ($extras === true): ?>
  <section class="unlocked-container">
  	<div data-scroll class="place__stretch-stretch grid gap__4 inner__4">
		<?= snippet('molecules/Blocks', [ 'blocks' => $page->extras()->toBlocks() ])?>
		<?php foreach ($page->extras()->toBlocks() as $block) {
		    if ($block->type() === 'image' && $blockImg = $block->image()->toFile()) {
		        $usedImages[] = $blockImg->id();
		    }
		    if ($block->type() === 'gallery') {
		        foreach ($block->images()->toFiles() as $galleryImg) {
		        	if ($galleryImg) { $usedImages[] = $galleryImg->id(); }
		        }
		    }
		} ?>
	</div>
  </section>
<?php endif; ?>

<?php if ($extras !== true): ?>
  <form id="password-form" method="POST" style="display: none;">
    <input type="password" name="secret_password" id="password-field">
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
  </form>
  <?php if (!empty($unlockError)): ?>
    <script>alert("<?= esc($unlockError) ?>");</script>
  <?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<section class="gallery" theme="invert">
	<div class="grid__2 gap__1 inner__4">
		<?php
			// Safely filter out already used images by converting the flat string array
			// var_dump($usedImages);
			$usedImages = array_values(array_filter(array_unique($usedImages)));
			$gallery = $page->gallery()->toFiles()->not($usedImages);
			// var_dump($gallery);
		?>
		<?php foreach ($gallery as $image) : ?>
			<?php if($image->orientation() == "landscape") : ?>
				<div class="grid span__2 inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__16/9']) ?></div>
			<?php else : ?>
				<div class="grid inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__1/1']) ?></div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>

<?= snippet('templates/globals/Projects/related', ['projects' => $similarProjects]) ?>

<?php $next = $page->nextListed() ?? collection('Projects')->first(); ?>
<?php if ($next) : ?>
<section class="next-project u1-block" theme="invert">
	<div class="u1-type-1">
		<!-- Left: Text (6 cols) -->
		<div class="u1-type-1__col-text">
			<div class="u1-type-1__top" data-scroll>
				<div class="u1-header">
					<div class="u1-label"><?= t('next-project', 'DALŠÍ PROJEKT') ?></div>
					<h2 class="u1-h2"><?= $next->title()->inline() ?></h2>
					<?php if ($next->intro()->isNotEmpty()) : ?>
						<p class="u1-perex"><?= $next->intro()->inline() ?></p>
					<?php endif ?>
				</div>
			</div>
			<div class="u1-type-1__bottom" data-scroll>
				<a href="<?= $next->url() ?>" class="button upper" theme="ghost" hover="dark"><?= t('view-project', 'Zobrazit projekt') ?></a>
			</div>
		</div>

		<!-- Right: Photo 4:3 (6 cols) -->
		<div class="u1-type-1__col-media" data-scroll>
			<?php if ($img = $next->cover()->toFile()) : ?>
				<div class="u1-photo" data-reveal-image>
					<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__full h__full']) ?>
				</div>
			<?php endif ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>