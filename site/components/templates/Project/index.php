<?php
	$usedImages = [];
?>

<section class="intro rounded-radius" theme="acc" style="--in-delay: 0ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover absolute inset-0 grid" data-scroll >
			<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?>
			<?php $usedImages[] = $cover?->id(); ?>
		</div>
	<?php endif ?>
	
	<div data-scroll class="z-10 intro__header content-end items-stretch grid grid-cols-1 md:grid-cols-4 h-screen md:h-auto p-1 pt-10 md:pt-1 gap-2 relative text-invert">
		<div class="col-span-1 md:col-span-4 grid gap-1 items-stretch">
			<h1 class=" secret-door ">
				<div data-reveal-text=""><?= $page->title() ?></div>
			</h1>
			<div class="grid grid-cols-1 md:grid-cols-4 border-t border-white/20 py-1">
				<a href="<?= $page->parent()->url() ?>" data-reveal-text="lines" class="uppercase text-s">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</a>
				<div data-reveal-text="lines" class="uppercase text-s">(<?= $page->date()->toDate('Y') ?>)</div>
			</div>
		</div>
	</div>

</section>

<section class="about" theme="invert">
	<div data-scroll class="grid grid-cols-1 md:grid-cols-2 gap-2 p-1 px-1 py-2">
		<div></div>
		<div class="col-span-1 grid content-start justify-start gap-3">
			<h2 data-reveal-text="lines" class="font-size-3 text-xs"><?= $page->intro()->inline() ?></h2>
		</div>
		<div></div>
		<div data-scroll class="grid py-2">
			<?php
			$specs = [
				'date' => 'Year',
				'client' => 'Client',
				'place' => 'Locality',
				'industry' => 'Industry',
				'space' => 'Space',
				'production' => 'Production',
				'size' => 'Size',
				'team' => 'Realizace',
				'collabs' => 'Collaborations',
				'photo'   => 'Photography',
				'concept' => 'Concept',
			];
			?>
			<?php foreach ($specs as $field => $label): ?>
				<?php $val = $page->$field(); ?>
				<?php if ($val->isNotEmpty()): ?>
					<div class="grid grid-cols-2 gap-2 border-t border-white/20 py-05">
						<div class="uppercase text-xs opacity-6">(<?= $label ?>)</div>
						<p class="text-large"><?= $field != 'date' ? $val : $val->toDate('Y') ?></p>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

		</div>
	</div>
</section>

<?php if ($page->before()->isNotEmpty() && $page->after()->isNotEmpty()): ?>
<?php
	$before = $page->before()->toFile();
	$after = $page->after()->toFile(); 
?>
<section>
	<div class="grid px-1" data-scroll>
		<div class="before-after-container rounded-img" style="--position: 41.75%;">
		  <div class="image-container before-image">
		  	<?= snippet('atoms/Image', ['img' => $before, 'parallax' => 2, 'reveal' => false, 'css' => '']) ?>
		  	<?php $usedImages[] = $before?->id(); ?>
		  </div>

		  <div class="image-container after-image">
		  	<?= snippet('atoms/Image', ['img' => $after, 'parallax' => 2, 'reveal' => false, 'css' => '']) ?>
		  	<?php $usedImages[] = $after?->id(); ?>
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
	<div data-scroll class="items-stretch grid gap-2 px-1 pt-2 pb-2">
		<?= snippet('molecules/Blocks', [ 'blocks' => $page->details()->toBlocks() ])?>
		<?php foreach ($page->details()->toBlocks() as $block) {
		    if ($block->type() === 'image' && $blockImg = $block->image()->toFile()) {
		        $usedImages[] = $blockImg?->id();
		    }
		    if ($block->type() === 'gallery') {
		        foreach ($block->images()->toFiles() as $galleryImg) {
		        	$usedImages[] = $galleryImg?->id();
		        }
		    }
		} ?>
	</div>
</section>

<?php if($page->password()->isNotEmpty()) : ?>
<?php if ($extras === true): ?>
  <section class="unlocked-container">
  	<div data-scroll class="items-stretch grid gap-2 px-1 pt-2 pb-5">
		<?= snippet('molecules/Blocks', [ 'blocks' => $page->extras()->toBlocks() ])?>
		<?php foreach ($page->extras()->toBlocks() as $block) {
		    if ($block->type() === 'image' && $blockImg = $block->image()->toFile()) {
		        $usedImages[] = $blockImg?->id();
		    }
		    if ($block->type() === 'gallery') {
		        foreach ($block->images()->toFiles() as $galleryImg) {
		        	$usedImages[] = $galleryImg?->id();
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
	<div class="grid grid-cols-1 md:grid-cols-2 gap-1 p-1 pb-3">
		<?php
			$usedImages = array_values(array_filter(array_unique($usedImages)));
			$gallery = $page->gallery()->toFiles()->not($usedImages);
		?>
		<?php foreach ($gallery as $image) : ?>
			<?php if($image->orientation() == "landscape") : ?>
				<div class="grid col-span-1 md:col-span-2 p-0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect-[16/9]']) ?></div>
			<?php else : ?>
				<div class="grid p-0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect-square']) ?></div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>

<?php if ($similarProjects) : ?>
<section class="projects rounded-radius" theme="light" >
	<div class="grid grid-cols-1 md:grid-cols-3 gap-1 pb-3 px-1 md:px-0" data-carousel>
		<div data-scroll class="col-span-1 md:col-span-2 px-1 pt-2">
			<h2 class="">Similar projects</h2>
		</div>
		<div class="flex gap-02 justify-end items-end px-1 text-base">
			<button data-carousel-prev class="button uppercase" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button uppercase" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="col-span-1 md:col-span-3" data-carousel-scroll>
			<ol class="flex justify-start items-center flex-nowrap gap-1 px-1" data-carousel-slides >	
			<?php foreach ($similarProjects as $project) : ?>
				<li data-slide class="project__wrapper w-[50vw] flex-shrink-0">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
				<li data-slide class="w-[60vw] flex-shrink-0 flex justify-end">	
					<div class="col-span-3 flex justify-center">
						<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
					</div>
				</li>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>

<?php $next = $page->nextListed() ?? collection('Projects')->first(); ?>
<?php if ($next) : ?>
<section class="intro rounded-radius" theme="invert" >
	<div data-scroll class="z-10 intro__header items-stretch justify-stretch grid grid-cols-1 md:grid-cols-4 h-screen intro__rows md:h-auto p-1 pt-10 md:pt-1 gap-2 relative ">
		<div class="h-1"></div>
		<a href="<?= $next->url() ?>" class="col-span-1 md:col-span-4 grid items-stretch">
			<div class="col-span-1 md:col-span-4 border-t border-white/20 pt-05 grid grid-cols-1 md:grid-cols-2 gap-2">

				<div class="grid grid-cols-2">
					<span class="uppercase text-s">(Next)</span>
				</div>
				<div class="grid gap-2 justify-between items-stretch">
					<div class="">
						<h2 class="font-size-1 text-xs">
							<div data-reveal-text=""><?= $next->title() ?></div>
						</h2>
					</div>
					<?php if ($cover = $next->cover()->toFile()) : ?>
					<div class="intro__cover grid col-span-2" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'grid']) ?></div>
					<?php endif ?>
					
				</div>
			</div>
		</a>
	</div>
</section>
<?php endif; ?>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>