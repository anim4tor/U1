<?php
/**
 * Šablona: Detail Realizace / Projekt (podle v65 realizace-*.html)
 */
$usedImages = [];
if ($cover = $page->cover()->toFile()) {
	$usedImages[] = $cover->id();
}

$similarProjects = $similarProjects ?? $page->siblings()->listed()->not($page)->limit(3);
?>

<?= snippet('sections/Hero/project') ?>

<!-- Sekce: O projektu & Parametry realizace -->
<section class="about project-intro radius" theme="invert" aria-label="O projektu">
	<div data-scroll class="grid__4 gap__3 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		
		<!-- Levý sloupec: Popis a Služby v projektu -->
		<div class="span__2 mobile:span__1 flex flex__dir__col justify__space-between gap__2">
			<div class="grid gap__2">
				
			<div class="grid gap__1 place__start-start">
				<?= snippet('atoms/Label', ['text' => t('about-project', 'O projektu')]) ?>
				<?php if ($page->intro()->isNotEmpty()): ?>
					<div data-reveal-text="lines" class="font__size__3 font__weight__500">
						<?= $page->intro()->inline() ?>
					</div>
				<?php endif ?>

			</div>

				<?php 
				$solutions = $page->solutions()->isNotEmpty() ? $page->solutions()->split() : [];
				if (!empty($solutions)): 
				?>
					<div class="project-solutions grid gap__1">
						<span class="label">Služby v projektu</span>
						<div class="flex wrap gap__05">
							<?php foreach ($solutions as $sol): ?>
								<?php 
								$solPage = site()->index()->filterBy('intendedTemplate', 'solution')->filterBy('title', $sol)->first() 
									?? site()->find('services/' . Str::slug($sol)) 
									?? page($sol);
								?>
								<?php if ($solPage): ?>
									<a href="<?= $solPage->url() ?>" class="button button--small button--tag" theme="ghost" hover="dark"><?= esc($solPage->title()) ?></a>
								<?php else: ?>
									<span class="button button--small button--tag op__7"><?= esc($sol) ?></span>
								<?php endif ?>
							<?php endforeach ?>
						</div>
					</div>
				<?php endif ?>

				<div class="">
					<?= snippet('atoms/Button', [
						'label' => 'Chci podobný projekt',
						'icon'  => 'arrow-right',
						'theme' => 'acc',
						'hover' => 'dark',
						'node'  => 'data-contact-toggle="inquiry"'
					]) ?>
				</div>
			
			</div>

			
		</div>

		<!-- Pravý sloupec: Specifikace a parametry -->
		<div class="span__2 mobile:span__1 project-specs grid gap__0 align__start" data-scroll>
			<?php
			$specs = [
				'date'       => 'Rok',
				'client'     => 'Klient',
				'place'      => 'Lokalita',
				'industry'   => 'Obor',
				'space'      => 'Typ prostoru',
				'size'       => 'Velikost',
				'team'       => 'Tým U1',
				'architect'  => 'Architektonický návrh',
				'photo'      => 'Fotografie',
				'production' => 'Výroba',
			];
			?>
			<?php foreach ($specs as $field => $label): ?>
				<?php 
				$val = $page->$field();
				if ($val->isNotEmpty()): 
					if ($field === 'date') {
						$formattedVal = $val->toDate('Y');
					} elseif ($field === 'team') {
						$teamArr = $page->team()->split();
						$formattedVal = !empty($teamArr) ? implode(', ', $teamArr) : $val->value();
					} elseif (is_array($val->value())) {
						$formattedVal = implode(', ', $val->value());
					} else {
						$formattedVal = $val->value();
					}
				?>
					<div class="grid__2 gap__2 border__top inner-y__05 mobile:gap__1">
						<?= snippet('atoms/Label', ['text' => $label]) ?>
						<p class="font__size__default"><?= esc($formattedVal) ?></p>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php 
			$customItems = $page->customInfo()->toStructure();
			if ($customItems->isNotEmpty()): 
				foreach ($customItems as $item): 
					if ($item->value()->isNotEmpty()): ?>
						<div class="grid__2 gap__2 border__top inner-y__05 mobile:gap__1">
							<?= snippet('atoms/Label', ['text' => $item->label()->isNotEmpty() ? $item->label() : $item->title()]) ?>
							<p class="font__size__default"><?= esc($item->value()) ?></p>
						</div>
					<?php endif; 
				endforeach; 
			else: 
				if ($page->concept()->isNotEmpty() && $page->architect()->isEmpty()): ?>
					<div class="grid__2 gap__2 border__top inner-y__05 mobile:gap__1">
						<?= snippet('atoms/Label', ['text' => 'Koncept']) ?>
						<p class="font__size__default"><?= esc($page->concept()) ?></p>
					</div>
				<?php endif; ?>
				<?php if ($page->collabs()->isNotEmpty()): ?>
					<div class="grid__2 gap__2 border__top inner-y__05 mobile:gap__1">
						<?= snippet('atoms/Label', ['text' => 'Spolupráce']) ?>
						<p class="font__size__default"><?= esc($page->collabs()) ?></p>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<!-- Před / Po interaktivní slider (volitelný) -->
		<?php if ($page->before()->isNotEmpty() && $page->after()->isNotEmpty()): ?>
		<?php
			$before = $page->before()->toFile();
			$after  = $page->after()->toFile(); 
		?>
		<div class="before-after-container vh__20 img__radius span__4" style="--position: 50%;">
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
		<?php endif; ?>

	</div>

</section>



<!-- Detaily realizace (příběh, kapitoly, editorial bloky) -->
<?php if ($page->details()->isNotEmpty() && $page->details()->toBlocks()->isNotEmpty()): ?>
<section class="details radius" theme="dark" aria-label="Popis realizace">
	<div data-scroll class="place__stretch-stretch grid gap__4 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
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
<?php endif; ?>

<!-- Odemčený obsah (za heslem, pokud existuje) -->
<?php if ($page->password()->isNotEmpty()) : ?>
<?php if ($extras === true): ?>
  <section class="unlocked-container radius" theme="dark">
  	<div data-scroll class="place__stretch-stretch grid gap__4 inner-x__4 inner-y__4 mobile:inner-x__1">
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
<?php else: ?>
  <form id="password-form" method="POST" style="display: none;">
    <input type="password" name="secret_password" id="password-field">
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
  </form>
  <?php if (!empty($unlockError)): ?>
    <script>alert("<?= esc($unlockError) ?>");</script>
  <?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<!-- Fotogalerie -->
<?php
$usedImages = array_values(array_filter(array_unique($usedImages)));
$gallery = $page->gallery()->toFiles()->not($usedImages);
?>
<?php if ($gallery->isNotEmpty()) : ?>
<section class="gallery radius" theme="dark" aria-label="Fotogalerie">
	<div class="grid__2 gap__2 inner-x__4 inner-y__4 mobile:grid__1 mobile:inner-x__1 mobile:inner-y__2">
		<?php foreach ($gallery as $image) : ?>
			<?php if ($image->orientation() === "landscape") : ?>
				<div class="grid span__2 inner__0" data-scroll>
					<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__16/9 img__radius']) ?>
				</div>
			<?php else : ?>
				<div class="grid inner__0" data-scroll>
					<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__4/3 img__radius']) ?>
				</div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>
<?php endif; ?>


<!-- Další realizace (Related carousel) -->
<?= snippet('sections/Projects/related', [
	'projects' => $similarProjects,
	'title'    => 'Další realizace',
	'theme'    => 'invert'
]) ?>

<!-- Články (Related articles carousel) -->
<?= snippet('sections/Feed/related') ?>

<!-- Výzva / CTA -->
<?= snippet('sections/Cta') ?>
