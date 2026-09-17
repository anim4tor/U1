<?php
	$usedImages = [];
?>

<section class="intro radius" theme="acc" style="--in-delay: 0ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover absolute inset__stretch grid" data-scroll >
			<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?>
			<?php $usedImages[] = $cover?->id(); ?>
		</div>
	<?php endif ?>
	
	<div data-scroll class="z__1 intro__header place__end-stretch grid__4 mobile:grid__1 h__100v mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__4 grid gap__1 place__stretch-stretch">
			<h1 class=" secret-door ">
				<div data-reveal-text=""><?= $page->title() ?></div>
			</h1>
			<div class="grid__4 border__top inner-y__1">
				<a href="<?= $page->parent()->url() ?>" data-reveal-text="lines" class="upper font__size__small">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</a>
				<div data-reveal-text="lines" class="upper font__size__small">(<?= $page->date()->toDate('Y') ?>)</div>
			</div>
		</div>
	</div>

</section>

<section class="about" theme="invert">
	<div data-scroll class="grid__4 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1 ">
		<div class="span__2">
			<div class="flex gap__05 align__center upper font__size__small no__wrap" data-scroll ><div class="w__05 h__05 bg__acc"></div><div data-reveal-text>About project</div></div>	
		</div>
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h3 data-reveal-text="lines" class="font__size__3"><?= $page->intro()->inline() ?></h3>
		</div>
		<div></div>
		<div></div>
		<div data-scroll class="grid span__2 mobile:grid__1">
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
<section theme="invert">
	<div class="grid inner-x__4 inner-b__4" data-scroll>
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
	<div data-scroll class="place__stretch-stretch grid gap__4 inner-x__4">
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
  	<div data-scroll class="place__stretch-stretch grid gap__4 inner-x__4">
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

<?php if ($similarProjects) : ?>
<section class="projects radius" theme="light" >
	<div class="grid__3 gap__1 mobile:grid__1 inner__4 mobile:inner-x__1 " data-carousel>
		<div data-scroll class="flex align__start gap__05 span__2">
			<div class="w__05 h__05 bg__acc"></div>
			<h2 class="">Similar projects</h2>
		</div>
		<div class="flex gap__02 justify__end align__end ">
			<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1  " data-carousel-slides >	
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
	<div data-scroll class="z__1 intro__header inner__4 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<a href="<?= $next->url() ?>" class="span__4 grid place__stretch-stretch">
			<div class="span__4 grid__4 gap__2">

				<div class="span__2">
					<div class="flex gap__05 align__center upper font__size__small no__wrap" data-scroll ><div class="w__05 h__05 bg__acc"></div><div data-reveal-text>NExt project</div></div>
					
				</div>
				<div class="span__2 grid gap__2 place__start-stretch">
					<h2 class="font__size__2">
						<div data-reveal-text=""><?= $next->title() ?></div>
					</h2>
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