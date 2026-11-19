<?php
/**
 * Sekce: Lidé / Tým (Layout podle Jakubovy verze v2)
 * Seznam zaměstnanců vlevo a sticky foto panel vpravo s přechodem do stínu.
 * U každého člověka se zobrazuje název vybraných projektů a stručný popis (bio).
 * Při větším počtu lidí (nad 8) je aktivován plynulý scroll (data-lenis-prevent).
 */
$employees = collection('Employees');
if (!$employees || $employees->isEmpty()) {
    $employees = page('about')->children()->listed();
}

if ($employees && $employees->isNotEmpty()) :

$allProjects = page('projects') ? page('projects')->children()->listed() : null;
$projectsOf = function ($name) use ($allProjects) {
    if (!$allProjects || empty($name)) return '';
    $matched = $allProjects->filter(function ($p) use ($name) {
        $text = (string)$p->v66facts() . (string)$p->team() . (string)$p->details() . (string)$p->quote();
        return str_contains($text, $name);
    });
    return implode(', ', $matched->pluck('title'));
};

$defaultData = [
    'michal-grof' => [
        'projects' => 'Volareza - Restaurace Evropa, CTPark Borská Pole',
        'bio'      => 'Obchodní a strategické vedení projektů od úvodního zadání po předání hotového interiéru.',
        'anchor'   => 'vedeni'
    ],
    'larisa-wright' => [
        'projects' => 'Direct pojišťovna, Restaurace Evropa',
        'bio'      => 'Koncepční prostorové studie, architektonické dispozice a integrace autorského mobiliáře U1.',
        'anchor'   => 'architektura'
    ],
    'jaromir-popek' => [
        'projects' => 'CTPark Borská Pole, FCC',
        'bio'      => 'Strategický rozvoj komplexních fit-out zakázek a koordinace klientských vztahů na Moravě.',
        'anchor'   => 'obchod'
    ],
    'nick-tan' => [
        'projects' => 'Plzeňský Prazdroj, Hartmann-Rico',
        'bio'      => 'Architektonické studie, dispoziční řešení a návrh autorského nábytku U1 pro flexibilní kanceláře.',
        'anchor'   => 'design'
    ],
    'jana-benesova' => [
        'projects' => 'Direct pojišťovna, Volareza - Restaurace Evropa',
        'bio'      => 'Detailní rozpracování interiérů, 3D vizualizace, materiálové moodboardy a vzorkování povrchů.',
        'anchor'   => 'architektura-a-design'
    ],
    'poppie-kenneally' => [
        'projects' => 'Hartmann-Rico, FCC',
        'bio'      => 'Vedení designérského týmu, prostorová identita a dohled nad jednotným konceptem interiérů.',
        'anchor'   => 'projektove-rizeni'
    ],
    'alexandra-green' => [
        'projects' => 'Ortho-Dent, Plzeňský Prazdroj',
        'bio'      => 'Návrhy atypických prvků a koordinace dispozičních řešení s technickým zázemím budovy.',
        'anchor'   => 'provozni-podpora'
    ],
    'connor-mcbeath' => [
        'projects' => 'Volareza - Restaurace Evropa, CTPark',
        'bio'      => 'Technická koordinace, dohled nad TZB instalacemi a stavební připraveností.',
        'anchor'   => 'stavebni-realizace'
    ],
    'daniel-hickey' => [
        'projects' => 'Plzeňský Prazdroj, Direct pojišťovna',
        'bio'      => 'Konceptuální architektura komerčních prostor a propojování zón pro soustředění a spolupráci.',
        'anchor'   => ''
    ],
    'hamish-maguire' => [
        'projects' => 'FCC, CTPark Borská Pole',
        'bio'      => 'Technická a materiálová řešení fit-outu s důrazem na akustiku a dlouhodobou udržitelnost.',
        'anchor'   => ''
    ],
    'johnny-hyde' => [
        'projects' => 'Hartmann-Rico, Volareza',
        'bio'      => 'Prostorová ergonomie, integrace technologií do pracovního prostředí a koordinace detailů.',
        'anchor'   => ''
    ],
    'rachael-mellick' => [
        'projects' => 'Direct pojišťovna, Ortho-Dent',
        'bio'      => 'Architektonické studie se zaměřením na biofilní design a přirozené světelné podmínky v kancelářích.',
        'anchor'   => ''
    ],
    'renee-smith' => [
        'projects' => 'CTPark Borská Pole, Plzeňský Prazdroj',
        'bio'      => 'Komplexní návrhy atypického nábytku Only1 a koordinace s truhlářskou výrobou.',
        'anchor'   => ''
    ],
    'sarah-tobin' => [
        'projects' => 'Volareza - Restaurace Evropa, FCC',
        'bio'      => 'Výběr povrchových materiálů, textilií a barevných schémat podporujících firemní kulturu.',
        'anchor'   => ''
    ],
    'sophie-oliver' => [
        'projects' => 'Hartmann-Rico, Direct pojišťovna',
        'bio'      => 'Detailní prostorový design, vzorkování a autorský dozor nad realizací interiérových detailů.',
        'anchor'   => ''
    ]
];

$peopleList = [];
$idx = 0;

foreach ($employees as $emp) {
    $slug = $emp->slug();
    $name = trim((string)$emp->title()->value());
    $role = trim((string)$emp->role()->value());
    $def = $defaultData[$slug] ?? [];

    $photoFile = $emp->photo()->toFile() ?? $emp->images()->first();

    $dynamicProjects = $projectsOf($name);
    $projects = $emp->projects()->isNotEmpty()
        ? $emp->projects()->value()
        : (!empty($dynamicProjects) ? $dynamicProjects : ($def['projects'] ?? ''));

    $bio = $emp->bio()->isNotEmpty()
        ? $emp->bio()->value()
        : ($def['bio'] ?? '');

    $anchor = $def['anchor'] ?? '';

    $peopleList[] = [
        'idx'        => $idx,
        'slug'       => $slug,
        'name'       => $name,
        'role'       => $role,
        'anchor'     => $anchor,
        'photoFile'  => $photoFile,
        'projects'   => $projects,
        'bio'        => $bio,
    ];

    $idx++;
}
$isScrollable = count($peopleList) > 8;
?>

<section class="people-section relative z__2" aria-labelledby="people-heading" data-tabs="hoverable">
   	<div class="bg absolute inset__stretch radius " theme="dark"></div>
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__4 mobile:gap__3 color__invert">
		
		<div class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="people-heading" class="font__size__2" data-reveal-text>Lidé</h2>
			</div>
			<div class="flex justify__end align__end">
				<p class="font__size__default op__7">Lidé, které znáte z našich realizací.</p>
			</div>
		</div>

		<div class="people__grid grid__12 gap__2 place__start-stretch relative">

			<div class="people__list-col span__8">
				<div class="people__list-wrapper' tabindex="0" aria-label="Seznam lidí"' : '' ?>
					<ul class="people__list">
						<?php foreach ($peopleList as $item) : ?>
							<li class="people__item"<?= !empty($item['anchor']) ? ' id="' . esc($item['anchor']) . '"' : '' ?> data-tab="person-<?= $item['idx'] ?>"<?= $item['idx'] === 0 ? ' data-active' : '' ?>>
								<div class="people__button">
									<h3 class="people__name"><?= esc($item['name']) ?></h3>
									<span class="font__size__small"><?= esc($item['role']) ?></span>
								</div>
								<div class="people__mobile-meta">
									<?php if (!empty($item['projects'])) : ?>
										<p class="people__mobile-projects"><strong>Vybrané projekty:</strong> <?= esc($item['projects']) ?></p>
									<?php endif ?>
									<?php if (!empty($item['bio'])) : ?>
										<p class="people__mobile-bio"><?= esc($item['bio']) ?></p>
									<?php endif ?>
								</div>
							</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
			<div class="people__photo-col sticky top__3 span__4" data-pane-container>
				<div class="people__photo-sticky " data-lenis-prevent>
					<?php foreach ($peopleList as $item) : ?>
						<div data-pane="person-<?= $item['idx'] ?>" class="people__photo-pane"<?= $item['idx'] === 0 ? ' data-active' : '' ?> data-tab-reveal>
							<figure class="people__figure img__radius">
								<?php if ($item['photoFile']) : ?>
									<?= snippet('atoms/Image', ['img' => $item['photoFile'], 'parallax' => false, 'reveal' => false, 'css' => 'img__radius']) ?>
								<?php else : ?>
									<div class="aspect__3/4 bg__dark flex align__center justify__center op__5"></div>
								<?php endif ?>
							</figure>
							<div class="people__photo-meta grid gap__05 place__end-stretch">
								<span class="people__meta-name"><?= esc($item['name']) ?></span>
								<span class="people__meta-role"><?= esc($item['role']) ?></span>
								<?php if (!empty($item['projects'])) : ?>
									<div class="people__meta-projects">
										<span class="people__meta-label">Vybrané projekty:</span>
										<span class="people__meta-val"><?= esc($item['projects']) ?></span>
									</div>
								<?php endif ?>
								<?php if (!empty($item['bio'])) : ?>
									<p class="people__meta-bio"><?= esc($item['bio']) ?></p>
								<?php endif ?>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>

	</div>
</section>
<?php endif ?>
