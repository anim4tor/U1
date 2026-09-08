<?php $usedImages = []; ?>
<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php $usedImages[] = $cover?->id(); ?>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 mobile:grid__1 h__100v intro__rows mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="h__1"></div>
		<div class="span__4 grid place__stretch-stretch">
			<div class="span__4 border__top inner-t__05 grid__4 place__space-between-stretch">
				<a href="<?= $page->parent()->url() ?>" data-reveal-text="lines" class="upper s">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</a>
				<div data-reveal-text="lines" class="upper s">(<?= $page->industry() ?>)</div>
				<div class="span__2">
					<h1 class="xs">
						<div data-reveal-text=""><?= $page->title() ?></div>
					</h1>
				</div>
				<div class="span__2"></div>
				<div class="span__2 grid__2 gap__2 relative place__end-stretch mobile:span__1 inner-y__05" style="--in-delay: 500ms">
					<!-- <div data-reveal-text="lines" class="upper s"><?= $page->client() ?></div> -->
					<!-- <div data-reveal-text="lines" class="upper s"><?= $page->space() ?></div> -->
					<div data-reveal-text="lines" class="upper s"><?= $page->date()->toDate('Y') ?></div>
					<div data-reveal-text="lines" class="upper s"><?= $page->place() ?></div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about" theme="invert">
	<div data-scroll class="grid grid__post gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div></div>
		<div class="span__1 grid place__start-start gap__3 mobile:inner-x__0">
			<h2 data-reveal-text="lines" class="font__size__3"><?= $page->intro()->inline() ?></h2>
		</div>
		<div></div>
		<div data-scroll class="grid mobile:grid__1 inner-y__2">
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
					<div class="grid__2 gap__2 border__top inner-y__05">
						<div class="upper font__size__small op__6">(<?= $label ?>)</div>
						<p class="font__size__large"><?= $field != 'date' ? $val : $val->toDate('Y') ?></p>
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
	<div class="grid inner-x__1" data-scroll>
		<div class="before-after-container vh__20 img__radius" style="--position: 41.75%;">
		  <div class="image-container before-image">
		  	<?= snippet('atoms/Image', ['img' => $before, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__20']) ?>
		  	<?php $usedImages[] = $before?->id(); ?>
		  </div>

		  <div class="image-container after-image">
		  	<?= snippet('atoms/Image', ['img' => $after, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__20']) ?>
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
	<div data-scroll class="place__stretch-stretch grid gap__2 inner-x__1 inner-t__2 inner-b__2">
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
  	<div data-scroll class="place__stretch-stretch grid gap__2 inner-x__1 inner-t__2 inner-b__5">
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
	<div class="grid__2 gap__1 inner__1 inner-b__3">
		<?php
			// Safely filter out already used images by converting the flat string array
			$usedImages = array_values(array_filter(array_unique($usedImages ?? [])));
			$gallery = $page->gallery()->toFiles()->not($usedImages);
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

<?php if ($similarProjects) : ?>
<section class="projects radius" theme="light" >
	<div class="grid__3 gap__1 mobile:grid__1 inner-b__3 mobile:inner-x__1 " data-carousel>
		<div data-scroll class="span__2 inner-x__1 inner-t__2 inner-b__">
			<h2 class="">Similar projects</h2>
		</div>
		<div class="flex gap__02 justify__end align__end inner-x__1">
			<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1 inner-x__1 " data-carousel-slides >	
			<?php foreach ($similarProjects as $project) : ?>
				<li data-slide class="project__wrapper vw__5">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
				<li data-slide class="vw__6 flex justify__end">	
					<div class="span__3 flex justify__center">
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
<section class="intro radius" theme="invert" >
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 mobile:grid__1 h__100v intro__rows mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="h__1"></div>
		<a href="<?= $next->url() ?>" class="span__4 grid place__stretch-stretch">
			<div class="span__4 border__top inner-t__05 grid grid__post gap__2">

				<div class="grid__2">
					<span class="upper font__size__small">(Next)</span>
				</div>
				<div class="grid gap__2 place__space-between-stretch">
					<div class="">
						<h2 class="font__size__1">
							<div data-reveal-text=""><?= $next->title() ?></div>
						</h2>
					</div>
					<?php if ($cover = $next->cover()->toFile()) : ?>
					<div class="intro__cover grid span__2 " data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'grid h__20']) ?></div>
					<?php endif ?>
					
				</div>
			</div>
		</a>
	</div>
</section>
<?php endif; ?>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>