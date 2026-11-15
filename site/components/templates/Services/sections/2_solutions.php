<?php
/**
 * Sekce: Výpis služeb (dle v65 sluzby.html s využitím interního design systému a layoutu U1)
 * 3 kategorie: Celý projekt, Stavba a technika, Nábytek a vybavení
 * Řádkový výpis v grid__4 s plovoucím náhledem fotky u kurzoru myši ([data-nahled])
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

// Výchozí texty jako spolehlivý fallback
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

        $foto = '';
        if ($sol) {
            $coverFile = $sol->cover()->toFile() ?? $sol->images()->first();
            if ($coverFile) {
                $foto = $coverFile->url();
            }
        }

        $groupedServices[$catName][] = [
            'num'   => str_pad($globalCounter++, 2, '0', STR_PAD_LEFT),
            'title' => $title,
            'desc'  => $desc,
            'url'   => $url,
            'foto'  => $foto
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

    $coverFile = $sol->cover()->toFile() ?? $sol->images()->first();
    $foto = $coverFile ? $coverFile->url() : '';

    $groupedServices[$cat][] = [
        'num'   => str_pad($globalCounter++, 2, '0', STR_PAD_LEFT),
        'title' => $sol->title()->value(),
        'desc'  => $desc,
        'url'   => $sol->url(),
        'foto'  => $foto
    ];
}
?>

<section class="services-section radius relative z__2" theme="invert" aria-label="<?= esc(t('services-list', 'Výpis služeb')) ?>" data-nahled>
	<!-- Plovoucí náhled fotografie u kurzoru myši -->
	<div class="services-preview radius no__overflow" aria-hidden="true" style="opacity: 0;">
		<img src="" alt="" hidden>
	</div>

	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__4 mobile:gap__3">
		<?php foreach ($groupedServices as $catName => $items) : ?>
			<?php if (empty($items)) continue; ?>
			<div class="services-group grid gap__1">
				<div class="services-group__header inner-b__05">
					<span class="label font__size__label op__5"><?= esc($catName) ?></span>
				</div>
				<ol class="services-group__list grid gap__0 border__bottom">
					<?php foreach ($items as $item) : ?>
						<li class="border__top">
							<a 
								href="<?= esc($item['url']) ?>" 
								class="services-item grid__4 gap__2 align__baseline inner-y__1 mobile:grid__1 mobile:gap__05 relative" 
								<?= !empty($item['foto']) ? 'data-foto="' . esc($item['foto']) . '"' : '' ?>
							>
								<div class="span__2 flex align__baseline gap__2 mobile:span__1">
									<span class="services-item__num font__size__small op__5 font__weight__500"><?= esc($item['num']) ?></span>
									<h3 class="services-item__title font__size__3" data-split-ignore><?= esc($item['title']) ?></h3>
								</div>
								<div class="span__2 flex align__baseline justify__space-between gap__2 mobile:span__1">
									<p class="services-item__desc font__size__default op__7"><?= esc($item['desc']) ?></p>
									<div class="services-item__arrow flex justify__end align__center flex__shrink__0">
										<?= snippet('atoms/Icon', ['name' => 'arrow-right']) ?>
									</div>
								</div>
							</a>
						</li>
					<?php endforeach ?>
				</ol>
			</div>
		<?php endforeach ?>
	</div>
</section>
