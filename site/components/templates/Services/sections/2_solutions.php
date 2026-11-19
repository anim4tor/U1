<?php
/**
 * Sekce: Výpis služeb (Čtvercové zobrazení v mřížce shodně jako u realizací)
 * 3 kategorie: Celý projekt, Stavba a technika, Nábytek a vybavení
 * Mřížka 3 sloupců (grid__3) s čtvercovými fotografiemi (aspect__1/1), parallaxem a hover efekty z realizací
 */

$servicesPage = $page ?? page('services');
$allSolutions = collection('Solutions');
if (!$allSolutions || $allSolutions->isEmpty()) {
    $allSolutions = $servicesPage ? $servicesPage->children()->listed() : new \Kirby\Cms\Pages();
}

// 1. Požadovaná struktura kategorií a slugů služeb
$categoryStructure = [
    'Celý projekt' => [
        'offices',
        'interior-design',
        'project-management',
        'fit-out',
        'realizace-pro-architekty'
    ],
    'Stavba a technika' => [
        'partitions',
        'ceilings',
        'flooring',
        'surfaces',
        'electrical',
        'air-conditioning'
    ],
    'Nábytek a vybavení' => [
        'interior-tailoring',
        'furniture',
        'equipment'
    ]
];

// Fallback názvy a popisy služeb
$defaultData = [
    'offices' => [
        'title' => 'Kanceláře na klíč',
        'desc'  => 'Navrhneme, postavíme a vybavíme vaše kanceláře. Za celý projekt odpovídáme my.'
    ],
    'interior-design' => [
        'title' => 'Návrh interiérů',
        'desc'  => 'Navrhneme, jak bude vaše kancelář uspořádaná a jak bude vypadat.'
    ],
    'project-management' => [
        'title' => 'Projektové řízení',
        'desc'  => 'Koordinujeme práci profesí, které váš interiér staví a vybavují.'
    ],
    'fit-out' => [
        'title' => 'Fit-out a stavební úpravy',
        'desc'  => 'Postavíme nové kanceláře nebo přestavíme stávající. Pracujeme podle vlastního i externího návrhu.'
    ],
    'realizace-pro-architekty' => [
        'title' => 'Realizace pro architekty',
        'desc'  => 'Postavíme interiér podle vašeho návrhu. Autorství zůstává vašemu studiu.'
    ],
    'partitions' => [
        'title' => 'Příčky a prosklené stěny',
        'desc'  => 'Příčky začleňujeme do stavební realizace podle návrhu kanceláře.'
    ],
    'ceilings' => [
        'title' => 'Stropy a akustické podhledy',
        'desc'  => 'Realizujeme akustické podhledy a atypické stropy podle návrhu interiéru.'
    ],
    'flooring' => [
        'title' => 'Podlahy a krytiny',
        'desc'  => 'Podlahy dodáváme jako součást realizace kanceláří i dalších interiérů.'
    ],
    'surfaces' => [
        'title' => 'Povrchy a materiály',
        'desc'  => 'Materiály a povrchy řešíme jako součást návrhu i realizace interiéru.'
    ],
    'electrical' => [
        'title' => 'Elektroinstalace a osvětlení',
        'desc'  => 'Elektromontáže zajišťujeme v rámci realizace interiéru podle projektu.'
    ],
    'air-conditioning' => [
        'title' => 'Vzduchotechnika a chlazení',
        'desc'  => 'Vzduchotechniku a chlazení zajišťujeme v rámci realizace interiéru podle projektu.'
    ],
    'interior-tailoring' => [
        'title' => 'Nábytek Only1, Only2 a atypy na míru',
        'desc'  => 'Nábytek na míru pro konkrétní prostor, od pracovních míst po recepci.'
    ],
    'furniture' => [
        'title' => 'Kancelářský nábytek',
        'desc'  => 'Dodáváme kancelářský nábytek, atypy na míru s ověřenými truhláři a vlastní nábytkové řady Only1 a Only2.'
    ],
    'equipment' => [
        'title' => 'Vybavení interiérů',
        'desc'  => 'Vybavíme pracovní místa i prostory, které váš tým sdílí.'
    ]
];

// Mapování fallback souborů fotografií
$fallbackImageMap = [
    'fit-out'                  => '20264-u1-yazaki-plzen-0112-1.webp',
    'partitions'               => '7.webp',
    'flooring'                 => 'dsc08682-interier-fcc-kancelare.webp',
    'surfaces'                 => 'pojistovna-direct-03-dsc00206-1.webp',
    'electrical'               => '2025-02-24-interier-vlnena-7-1.webp',
    'furniture'                => 'dsc08731-interier-fcc-kancelare.webp',
    'equipment'                => 'evropa1003dse3646-hdr-2.webp',
    'ceilings'                 => 'dsf0864a4.webp',
];

// Helper pro vyhledání obrázku
$findServiceImage = function($sol, $slug) use ($servicesPage, $fallbackImageMap) {
    if ($sol) {
        $img = $sol->cover()->toFile() ?? $sol->images()->first();
        if ($img) return $img;
    }
    if (isset($fallbackImageMap[$slug])) {
        $fn = $fallbackImageMap[$slug];
        $img = $servicesPage ? $servicesPage->image($fn) : null;
        if (!$img && function_exists('site')) {
            $img = site()->index()->images()->findBy('filename', $fn);
        }
        if ($img) return $img;
    }
    return $servicesPage ? $servicesPage->images()->first() : null;
};

// 2. Indexace dostupných stránek
$solutionsBySlug = [];
foreach ($allSolutions as $solution) {
    $solutionsBySlug[$solution->slug()] = $solution;
}

// 3. Sestavení finálních skupin s průběžným číslováním 01-14
$groupedServices = [];
$globalCounter = 1;

foreach ($categoryStructure as $catName => $slugs) {
    $groupedServices[$catName] = [];
    foreach ($slugs as $slug) {
        $sol = $solutionsBySlug[$slug] ?? null;
        $fallback = $defaultData[$slug] ?? null;

        $title = $sol ? $sol->title()->value() : ($fallback['title'] ?? ucfirst(str_replace('-', ' ', $slug)));
        
        $desc = '';
        if ($sol && $sol->excerpt()->isNotEmpty()) {
            $desc = trim(strip_tags($sol->excerpt()->value()));
        } elseif ($sol && $sol->intro()->isNotEmpty()) {
            $desc = trim(strip_tags($sol->intro()->value()));
        } elseif ($fallback) {
            $desc = $fallback['desc'];
        }

        $url = $sol ? $sol->url() : url('services/' . $slug);
        $coverFile = $findServiceImage($sol, $slug);

        $groupedServices[$catName][] = [
            'num'   => str_pad($globalCounter++, 2, '0', STR_PAD_LEFT),
            'title' => $title,
            'desc'  => $desc,
            'url'   => $url,
            'cover' => $coverFile
        ];

        unset($solutionsBySlug[$slug]);
    }
}

// 4. Zařazení případných dodatečných stránek přidaných v administraci
foreach ($solutionsBySlug as $sol) {
    $cat = $sol->category()->value();
    if (empty($cat) || !isset($groupedServices[$cat])) {
        $cat = 'Celý projekt';
    }
    
    $desc = '';
    if ($sol->excerpt()->isNotEmpty()) {
        $desc = trim(strip_tags($sol->excerpt()->value()));
    } elseif ($sol->intro()->isNotEmpty()) {
        $desc = trim(strip_tags($sol->intro()->value()));
    }

    $coverFile = $findServiceImage($sol, $sol->slug());

    $groupedServices[$cat][] = [
        'num'   => str_pad($globalCounter++, 2, '0', STR_PAD_LEFT),
        'title' => $sol->title()->value(),
        'desc'  => $desc,
        'url'   => $sol->url(),
        'cover' => $coverFile
    ];
}
?>

<section class="services-section list radius relative z__2" theme="invert" aria-label="<?= esc(t('services-list', 'Výpis služeb')) ?>">
	<div class="inner__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__5 mobile:gap__4">
		<?php foreach ($groupedServices as $catName => $items) : ?>
			<?php if (empty($items)) continue; ?>
			<div class="services-group grid gap__2">
				<ol class="grid__3 gap__2 gap-y__3 mobile:grid__1">
					<?php foreach ($items as $item) : ?>
						<li data-slide class="list-none">
							<div class="item --project --service relative" data-scroll>
								<a href="<?= esc($item['url']) ?>" class="grid gap__1 relative">	
									<div class="relative">
										<?php if (!empty($item['cover'])) : ?>
											<div class="item__figure grid img__radius">
												<?= snippet('atoms/Image', [
													'img'      => $item['cover'], 
													'parallax' => 1, 
													'reveal'   => true, 
													'css'      => 'aspect__4/3', 
													'node'     => 'data-reveal-image'
												]) ?>
											</div>
										<?php endif ?>
									</div>
									<div class="item__meta relative grid gap__05">
										<div class="font__size__small op__7"><?= esc($catName) ?> · <?= esc($item['num']) ?></div>
										<h3 class="wrap"><?= esc($item['title']) ?></h3>
										<?php if (!empty($item['desc'])) : ?>
											<p class="services-item__desc font__size__default op__7"><?= esc($item['desc']) ?></p>
										<?php endif ?>
									</div>
								</a>
							</div>
						</li>
					<?php endforeach ?>
				</ol>
			</div>
		<?php endforeach ?>
	</div>
</section>
