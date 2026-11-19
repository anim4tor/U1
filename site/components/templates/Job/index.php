<?php
/**
 * Šablona: Detail Pozice / Job (podle v65 kariera-*.html s layoutem podle Solutions a design systému U1)
 */
$cover = $page->cover()->toFile() 
    ?? site()->images()->filterBy('name', '*=', 'career')->first() 
    ?? site()->images()->first();

$location = $page->location()->or('Brno / Praha');
$duration = $page->duration()->or('Plný úvazek (HPP)');
$start = $page->start()->or('Ihned / dohodou');
$team = $page->team()->or('Realizační tým U1');
$email = $page->contactEmail()->or('hr@u1.cz');
$phone = $page->contactPhone()->or('+420 601 088 517');

$perex = $page->excerpt()->isNotEmpty() ? $page->excerpt()->inline() : null;

// Strukturované položky
$description = $page->description()->toStructure();
$requirements = $page->requirements()->toStructure();
$offers = $page->offers()->toStructure();
if ($offers->isEmpty()) {
    $offers = $page->benefits()->toStructure();
}

// Ostatní volné pozice pro pravý sloupec (obdoba "Další služby" v Solutions)
$otherJobs = $page->siblings()->listed()->not($page)->limit(4);
if ($otherJobs->isEmpty()) {
    $careerPage = site()->find('career') ?? site()->find('5_career');
    if ($careerPage) {
        $otherJobs = $careerPage->index()->filterBy('intendedTemplate', 'job')->not($page)->limit(4);
    }
}

// Ikony pro sekci Benefity podle v65
$benefitIcons = [
    'bonusy'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><circle cx="12" cy="12" r="8"></circle><path d="M12 8v8M9.5 10.5c0-1 1-1.5 2.5-1.5s2.5.6 2.5 1.6c0 2.3-5 1.2-5 3.4 0 1 1 1.6 2.5 1.6s2.5-.5 2.5-1.5"></path></svg>',
    'provize'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><path d="M5 19L19 5"></path><circle cx="7" cy="7" r="2"></circle><circle cx="17" cy="17" r="2"></circle></svg>',
    'telefon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><rect x="7" y="3" width="10" height="18" rx="2"></rect><path d="M11 18h2"></path></svg>',
    'notebook'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><rect x="5" y="5" width="14" height="10" rx="1"></rect><path d="M3 19h18"></path></svg>',
    'sleva'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><path d="M3 12V4h8l10 10-8 8z"></path><circle cx="7.5" cy="8.5" r="1.2"></circle></svg>',
    'kurzy'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><path d="M2 9l10-5 10 5-10 5z"></path><path d="M6 11v5c3 2 9 2 12 0v-5"></path></svg>',
    'obcerstveni' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><path d="M5 9h11v5a5 5 0 0 1-5 5h-1a5 5 0 0 1-5-5z"></path><path d="M16 10h2a2 2 0 0 1 0 4h-2M9 3v3M12 3v3"></path></svg>',
    'volno'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"></path></svg>',
    'akce'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><rect x="4" y="5" width="16" height="15" rx="1"></rect><path d="M4 10h16M9 3v4M15 3v4"></path></svg>',
    'hodiny'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3"></path></svg>',
    'default'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 22px; height: 22px;"><circle cx="12" cy="12" r="8"></circle><path d="M12 8v8M9.5 10.5c0-1 1-1.5 2.5-1.5s2.5.6 2.5 1.6c0 2.3-5 1.2-5 3.4 0 1 1 1.6 2.5 1.6s2.5-.5 2.5-1.5"></path></svg>'
];

function resolveBenefitIcon($text, $iconKey, $benefitIcons) {
    $t = mb_strtolower($text);
    if ($iconKey === 'shield-check' || str_contains($t, 'bonus') || str_contains($t, 'prémi')) return $benefitIcons['bonusy'];
    if ($iconKey === 'users' || str_contains($t, 'proviz')) return $benefitIcons['provize'];
    if ($iconKey === 'briefcase' || str_contains($t, 'telefon') || str_contains($t, 'mobil')) return $benefitIcons['telefon'];
    if ($iconKey === 'sun' || str_contains($t, 'notebook') || str_contains($t, 'počítač')) return $benefitIcons['notebook'];
    if ($iconKey === 'heart' || str_contains($t, 'slev')) return $benefitIcons['sleva'];
    if ($iconKey === 'users-1' || str_contains($t, 'kurz') || str_contains($t, 'školen') || str_contains($t, 'vzděláv')) return $benefitIcons['kurzy'];
    if ($iconKey === 'heart-1' || str_contains($t, 'občerstv') || str_contains($t, 'káv')) return $benefitIcons['obcerstveni'];
    if ($iconKey === 'sun-1' || str_contains($t, 'volno') || str_contains($t, 'sick')) return $benefitIcons['volno'];
    if ($iconKey === 'users-2' || str_contains($t, 'akce') || str_contains($t, 'teambuilding')) return $benefitIcons['akce'];
    if ($iconKey === 'users-3' || str_contains($t, 'hodin') || str_contains($t, 'napracov') || str_contains($t, 'flexibil')) return $benefitIcons['hodiny'];
    return $benefitIcons['default'];
}

$benefitsStructure = $page->whyus()->toStructure();
$benefitsItems = [];

if ($benefitsStructure->isNotEmpty()) {
    foreach ($benefitsStructure as $item) {
        $text = $item->text()->value();
        $iconKey = $item->icon()->value();
        $benefitsItems[] = [
            'text' => $text,
            'icon' => resolveBenefitIcon($text, $iconKey, $benefitIcons)
        ];
    }
} else {
    $fallbackList = [
        ['text' => 'Bonusy a prémie', 'key' => 'bonusy'],
        ['text' => 'Provize z prodeje', 'key' => 'provize'],
        ['text' => 'Mobilní telefon', 'key' => 'telefon'],
        ['text' => 'Notebook', 'key' => 'notebook'],
        ['text' => 'Sleva na firemní výrobky a služby', 'key' => 'sleva'],
        ['text' => 'Vzdělávací kurzy', 'key' => 'kurzy'],
        ['text' => 'Občerstvení na pracovišti', 'key' => 'obcerstveni'],
        ['text' => 'Zdravotní volno', 'key' => 'volno'],
        ['text' => 'Firemní akce', 'key' => 'akce']
    ];
    foreach ($fallbackList as $fb) {
        $benefitsItems[] = [
            'text' => $fb['text'],
            'icon' => $benefitIcons[$fb['key']]
        ];
    }
}

// Položky pro záložku Požadavky
$requirementsStructure = $page->requirements()->toStructure();
$requirementsItems = [];
if ($requirementsStructure->isNotEmpty()) {
    foreach ($requirementsStructure as $req) {
        $requirementsItems[] = [
            'text' => $req->text()->value()
        ];
    }
} else {
    $fallbackRequirements = [
        'Praxe na obdobné pozici v oboru interiérů, architektury nebo stavebního fit-outu',
        'Samostatnost, spolehlivost a tah na branku při řešení úkolů',
        'Schopnost koordinace subdodavatelů, technické myšlení a smysl pro detail',
        'Příjemné vystupování a profesionální komunikace s klienty i partnery',
        'Uživatelská znalost práce na PC (MS Office / CAD nástroje)',
        'Řidičský průkaz skupiny B'
    ];
    foreach ($fallbackRequirements as $fr) {
        $requirementsItems[] = ['text' => $fr];
    }
}
?>

<!-- Hero sekce služby -->
<?= snippet('sections/Hero/') ?>

<!-- Hlavní sekce: O pozici & Parametry (layout podle Solutions a U1 Design System) -->
<section class="about job-intro" theme="invert" aria-label="O pozici">
	<div data-scroll class="grid__8 gap__3 place__start-stretch mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">

		<!-- Pravý sloupec: Specifikace pozice & Další pozice (přesně podle Solutions) -->
		<div class="span__3 sticky top__3 mobile:span__1 job-specs grid gap__2 align__start" data-scroll>
			
			<div class="grid">
				
				<div class="grid__2 gap__2 place__start-start border__top inner-y__05 mobile:gap__1">
					<?= snippet('atoms/Label', ['text' => 'Místo']) ?>
					<p class="font__size__default"><?= esc($location) ?></p>
				</div>

				<div class="grid__2 gap__2 place__start-start border__top inner-y__05 mobile:gap__1">
					<?= snippet('atoms/Label', ['text' => 'Úvazek']) ?>
					<p class="font__size__default"><?= esc($duration) ?></p>
				</div>

				<div class="grid__2 gap__2 place__start-start border__top inner-y__05 mobile:gap__1">
					<?= snippet('atoms/Label', ['text' => 'Nástup']) ?>
					<p class="font__size__default"><?= esc($start) ?></p>
				</div>

				<div class="grid__2 gap__2 place__start-start border__top inner-y__05 mobile:gap__1">
					<?= snippet('atoms/Label', ['text' => 'Tým']) ?>
					<p class="font__size__default"><?= esc($team) ?></p>
				</div>

				<div class="grid__2 gap__2 place__start-start border__top inner-y__05 mobile:gap__1">
					<?= snippet('atoms/Label', ['text' => 'Kontakt']) ?>
					<div class="font__size__default grid gap__01">
						<a href="mailto:<?= esc($email) ?>" class="link font__weight__600"><?= esc($email) ?></a>
						<a href="tel:<?= esc(str_replace(' ', '', $phone)) ?>" class="link"><?= esc($phone) ?></a>
					</div>
				</div>
			</div>

			<div class="">
				<?= snippet('atoms/Button', [
					'label' => 'Mám zájem o pozici',
					'icon'  => 'arrow-right',
					'theme' => 'acc',
					'hover' => 'dark',
					'node'  => 'data-contact-toggle="inquiry"'
				]) ?>
			</div>

			<!-- Další volné pozice (přesně jako Další služby v Solutions) -->
			<?php if ($otherJobs->isNotEmpty()): ?>
				<div class="grid gap__1">
					<?= snippet('atoms/Label', ['text' => 'Další volné pozice']) ?>
					<div class="grid gap__0">
						<?php foreach ($otherJobs as $otherJob): ?>
							<a href="<?= $otherJob->url() ?>" class="flex justify__space-between align__center inner-y__05 border__bottom link">
								<span class="font__size__default"><?= esc($otherJob->title()) ?></span>
								<span class="color__acc font__size__small">→</span>
							</a>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>

		</div>
		<div></div>
		<!-- Levý sloupec: Popis a rozsah pozice -->
		<div class="span__4 mobile:span__1 flex flex__dir__col justify__space-between gap__3">
			<div class="grid gap__3">
				
				<div class="grid gap__1">
					
				<div class="grid gap__1 place__start-start">
					<?php if ($perex): ?>
						<div data-reveal-text="lines" class="font__size__3 font__weight__500">
							<?= $perex ?>
						</div>
					<?php endif ?>
				</div>

				<?php if ($page->details()->isNotEmpty()): ?>
					<div class="font__size__default op__8 leading__relaxed grid gap__1">
						<?= $page->details() ?>
					</div>
				<?php endif ?>

				</div>

				<!-- Náplň práce -->
				<?php if ($description->isNotEmpty()): ?>
					<div class="job-group grid gap__1">
						<h3 class="larger"><?= t('job.description', 'Náplň práce') ?></h3>
						<ul class="grid gap__05 list-unstyled">
							<?php foreach ($description as $item): ?>
								<li class="flex gap__1 align__start">
									<span class="color__acc font__size__small shrink__0">✓</span>
									<span class="font__size__default op__8"><?= esc($item->text()) ?></span>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>

				<!-- Nabízíme -->
				<?php if ($offers->isNotEmpty()): ?>
					<div class="job-group grid gap__1">
						<h3 class="larger"><?= t('job.offers', 'Co vám nabízíme') ?></h3>
						<ul class="grid gap__05 list-unstyled">
							<?php foreach ($offers as $item): ?>
								<li class="flex gap__1 align__start">
									<span class="color__acc font__size__small shrink__0">✓</span>
									<span class="font__size__default op__8"><?= esc($item->text()) ?></span>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>

			</div>
		</div>

	</div>
</section>

<!-- Sekce: Benefity a požadavky (Tabs layout podle v2) -->
<section class="benefits-section radius relative z__2" theme="dark" aria-labelledby="ben-h" data-tabs="default">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="benefits__header">
			<div class="benefits__tabs flex gap__1 align__center " role="tablist" aria-label="Benefity a požadavky">
				<h2 role="tab" class=" is-active" data-tab="benefits" aria-selected="true" data-active id="ben-h">Benefity</h2>
				<div class="w__03 h__03 bg__invert op__4"></div>
				<h2 role="tab" class="" data-tab="requirements" aria-selected="false">Požadavky</h2>
			</div>
		</div>

		<div data-pane-container>
			<!-- Záložka: Benefity -->
			<div data-pane="benefits" class="benefits__pane" data-active data-tab-reveal>
				<ul class="grid__3 gap-x__2 gap-y__0" data-scroll>
					<?php foreach ($benefitsItems as $bItem) : ?>
						<li class="benefits__item">
							<span class="benefits__item-icon">
								<?= $bItem['icon'] ?>
							</span>
							<span class="benefits__item-text"><?= esc($bItem['text']) ?></span>
						</li>
					<?php endforeach ?>
				</ul>
			</div>

			<!-- Záložka: Požadavky -->
			<div data-pane="requirements" class="benefits__pane" data-tab-reveal>
				<ul class="grid__3 gap-x__2 gap-y__0" data-scroll>
					<?php foreach ($requirementsItems as $rItem) : ?>
						<li class="benefits__item benefits__item--requirement">
							<span class="benefits__item-icon -wrap-t__02">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width: 18px; height: 18px;">
									<polyline points="20 6 9 17 4 12"/>
								</svg>
							</span>
							<span class="benefits__item-text"><?= esc($rItem['text']) ?></span>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>

	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.benefits-section').forEach(sec => {
		const tabs = sec.querySelectorAll('.benefits__tab[data-tab]');
		const panes = sec.querySelectorAll('.benefits__pane[data-pane]');
		tabs.forEach(tab => {
			tab.addEventListener('click', function(e) {
				e.preventDefault();
				const target = this.getAttribute('data-tab');
				tabs.forEach(t => {
					const isActive = t === tab;
					t.classList.toggle('is-active', isActive);
					t.setAttribute('aria-selected', String(isActive));
					t.toggleAttribute('data-active', isActive);
				});
				panes.forEach(p => {
					const isActive = p.getAttribute('data-pane') === target;
					p.toggleAttribute('data-active', isActive);
				});
			});
		});
	});
});
</script>

<!-- Recenze zaměstnanců (2-sloupcové taby se šipkami a fotkou projektu) -->
<?= snippet('templates/Career/sections/5_references', ['theme' => 'light']) ?>

<!-- Průběh výběrového řízení -->
<?= snippet('templates/Career/sections/4_process') ?>



<!-- Články ze života v U1 -->
<?= snippet('sections/Feed/related') ?>

<!-- CTA zápatí -->
<?= snippet('sections/Cta/career') ?>
