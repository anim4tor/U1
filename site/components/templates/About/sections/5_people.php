<?php
/**
 * Sekce: Lidé (Layout ve stylu Ocenění / Služeb)
 * Řádkový výpis zaměstnanců v grid__4 s rozdělením do týmů.
 * Na hover se v posledním sloupci zobrazí fotografie daného člověka
 * v absolutní pozici vycentrované na výšku řádku.
 */
$employees = collection('Employees');
if (!$employees || $employees->isEmpty()) {
    $employees = page('about')->children()->listed();
}
?>

<?php if ($employees && $employees->isNotEmpty()) : ?>
<?php
// Skupiny týmů s aliasy pro bezpečné párování
$teamDefinitions = [
    [
        'id'      => 'vedeni',
        'name'    => 'Vedení',
        'aliases' => ['Vedení', 'Management', 'Board']
    ],
    [
        'id'      => 'obchod',
        'name'    => 'Obchod',
        'aliases' => ['Obchod', 'Obchodní oddělení', 'Sales']
    ],
    [
        'id'      => 'architektura-a-design',
        'name'    => 'Architektura a design',
        'aliases' => ['Architektura a design', 'Design & Architektura', 'Architektura', 'Design']
    ],
    [
        'id'      => 'projektove-rizeni',
        'name'    => 'Projektové řízení',
        'aliases' => ['Projektové řízení', 'Project Management', 'Projektanti']
    ],
    [
        'id'      => 'stavebni-realizace',
        'name'    => 'Stavební realizace',
        'aliases' => ['Stavební realizace', 'Realizace & servis', 'Realizace']
    ],
    [
        'id'      => 'provozni-podpora',
        'name'    => 'Provozní podpora',
        'aliases' => ['Provozní podpora', 'Operations', 'Backoffice', 'Provoz']
    ],
];

// Připravíme seznam skupin pro render
$groups = [];
$assignedSlugs = [];

foreach ($teamDefinitions as $def) {
    $matched = $employees->filter(function($emp) use ($def) {
        $empTeam = trim((string)$emp->team()->value());
        return in_array($empTeam, $def['aliases'], true) || strcasecmp($empTeam, $def['name']) === 0;
    });

    if ($matched->isNotEmpty()) {
        $groups[] = [
            'id'        => $def['id'],
            'name'      => $def['name'],
            'employees' => $matched
        ];
        foreach ($matched as $m) {
            $assignedSlugs[] = $m->slug();
        }
    }
}

// Fallback pro jakékoli zaměstnance, kteří nespadli do výše uvedených skupin
$unassigned = $employees->filter(function($emp) use ($assignedSlugs) {
    return !in_array($emp->slug(), $assignedSlugs, true);
});

if ($unassigned->isNotEmpty()) {
    $unassignedTeams = $unassigned->pluck('team', null, true);
    foreach ($unassignedTeams as $uTeam) {
        $uName = !empty($uTeam) ? (string)$uTeam : 'Ostatní';
        $uMatched = $unassigned->filterBy('team', $uTeam);
        $groups[] = [
            'id'        => \Kirby\Toolkit\Str::slug($uName),
            'name'      => $uName,
            'employees' => $uMatched
        ];
    }
}
?>

<section class="people-section radius relative z__2" theme="dark" aria-labelledby="people-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__4 mobile:gap__3">
		
		<div class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="people-heading" class="font__size__2" data-reveal-text>Lidé</h2>
			</div>
			<div class=" flex align__end">
				<p class="font__size__default op__7">Lidé, které znáte z našich realizací.</p>
			</div>
		</div>

		<?php foreach ($groups as $group) : ?>
			<div id="<?= esc($group['id']) ?>" class="people-group grid gap__1">
				<div class="people-group__header inner-b__05" data-scroll>
					<span class="label font__size__label color__acc"><?= esc($group['name']) ?></span>
				</div>
				<ol class="people-group__list grid gap__0 border__bottom" data-scroll>
					<?php foreach ($group['employees'] as $employee) : ?>
						<?php $photoFile = $employee->photo()->toFile(); ?>
						<li class="border__top">
							<div class="people-item grid__4 gap__2 align__center inner-y__1 mobile:grid__1 mobile:gap__05 relative">
								<div class="span__2 mobile:span__1">
									<h3 class="people-item__name font__size__3" data-split-ignore><?= esc($employee->title()) ?></h3>
								</div>
								<div class="span__1 mobile:span__1">
									<p class="people-item__role font__size__default op__7"><?= esc($employee->role()) ?></p>
								</div>
								<div class="span__1 hide--mobile flex justify__end align__center relative">
									<?php if ($photoFile) : ?>
										<div class="people-item__photo">
											<?= snippet('atoms/Image', ['img' => $photoFile, 'parallax' => false, 'reveal' => false, 'css' => 'img__radius']) ?>
										</div>
									<?php endif ?>
								</div>
							</div>
						</li>
					<?php endforeach ?>
				</ol>
			</div>
		<?php endforeach ?>

	</div>
</section>
<?php endif ?>
