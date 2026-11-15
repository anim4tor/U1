<?php
/**
 * Sekce: Volné pozice (v65 kariera.html)
 * Řádkový výpis volných míst v našem designovém systému
 */
$heading = $page->positionsHeading()->or('Volné pozice');
$subtitle = $page->positionsSubtitle()->or('Vhodnou pozici nevidíte? Pošlete nám životopis na hr@u1.cz.');

$positions = [];

// 1. Zkusíme načíst z podstránek positions
$subpage = $page->find('positions');
if ($subpage && $subpage->children()->listed()->isNotEmpty()) {
    foreach ($subpage->children()->listed() as $pos) {
        $loc = $pos->location()->value();
        if ($pos->slug() === 'project-manager' && !str_contains($loc, 'úvazek')) {
            $loc = 'Brno · plný úvazek';
        }
        $positions[] = [
            'title'    => $pos->title()->value(),
            'location' => $loc ?: 'Brno',
            'url'      => $pos->url()
        ];
    }
}

// 2. Pokud nejsou podstránky, načteme z pole positionsList
if (empty($positions) && $page->positionsList()->isNotEmpty()) {
    foreach ($page->positionsList()->toStructure() as $pos) {
        $positions[] = [
            'title'    => $pos->title()->value(),
            'location' => $pos->location()->or('Brno')->value(),
            'url'      => $pos->url()->or('mailto:hr@u1.cz?subject=' . rawurlencode($pos->title()->value()))
        ];
    }
}

// 3. Fallback na v65 data
if (empty($positions)) {
    $positions = [
        ['title' => 'Projektový manažer', 'location' => 'Brno · plný úvazek', 'url' => url('kariera/positions/project-manager')],
        ['title' => 'Rozpočtář stavební části interiéru', 'location' => 'Brno', 'url' => 'mailto:hr@u1.cz?subject=' . rawurlencode('Rozpočtář stavební části interiéru')],
        ['title' => 'Obchodní manažer', 'location' => 'Brno', 'url' => 'mailto:hr@u1.cz?subject=' . rawurlencode('Obchodní manažer')],
        ['title' => 'Kalkulant interiérů', 'location' => 'Brno', 'url' => 'mailto:hr@u1.cz?subject=' . rawurlencode('Kalkulant interiérů')],
        ['title' => 'Designér', 'location' => 'Brno', 'url' => 'mailto:hr@u1.cz?subject=' . rawurlencode('Designér')]
    ];
}
?>

<section class="positions-section radius relative z__2" theme="invert" aria-labelledby="positions-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="positions-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
			</div>
			<div class=" flex align__end">
				<p class="font__size__default op__7">
					<?= esc($subtitle) ?>
				</p>
			</div>
		</div>

		<ol class="grid gap__0 border__bottom" data-scroll>
			<?php foreach ($positions as $item) : ?>
				<li class="border__top">
					<a href="<?= esc($item['url']) ?>" class="career-position grid__4 gap__2 align__center inner-y__1 mobile:grid__1 mobile:gap__02 relative">
						<h3 class="career-position__title span__2 font__size__3 mobile:span__1" data-split-ignore>
							<?= esc($item['title']) ?>
						</h3>
						<span class="span__1 font__size__small op__6 mobile:span__1">
							<?= esc($item['location']) ?>
						</span>
						<div class="career-position__arrow span__1 flex justify__end align__center mobile:hidden">
							<?= snippet('atoms/Icon', ['name' => 'arrow-right']) ?>
						</div>
					</a>
				</li>
			<?php endforeach ?>
		</ol>

	</div>
</section>
