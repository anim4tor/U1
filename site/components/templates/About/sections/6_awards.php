<?php
/**
 * Sekce: Ocenění a nominace (Layout podle Jakubovy verze v2)
 * Dynamické listování: při najetí na ocenění/nominaci se v levém panelu mění náhledový obrázek/projekt.
 * Přímo v textu položky jasně odlišeno vítězství od nominace (pomocí odznaku i textu).
 */
$heading = $page->awardsHeading()->isNotEmpty() ? $page->awardsHeading()->value() : 'Ocenění a nominace';
$rawAwards = $page->awards()->toStructure();

$defaultAwards = [
    [
        'year'    => '2025',
        'title'   => 'Kanceláře roku',
        'detail'  => 'Direct pojišťovna',
        'status'  => 'winner',
        'project' => 'projects/direct-pojistovna',
        'url'     => 'https://www.e15.cz/byznys/reality-a-stavebnictvi/nejlepsi-kancelare-roku-ukazuji-nove-trendy-tohle-jsou-spickove-realizace-v-cesku-1433365'
    ],
    [
        'year'    => '2023',
        'title'   => 'Architekt roku & Grand Prix architektů',
        'detail'  => 'Volareza Restaurace Evropa',
        'status'  => 'nomination',
        'project' => 'projects/volareza-restaurace-evropa',
        'url'     => ''
    ],
    [
        'year'    => '2022',
        'title'   => 'Interiér roku',
        'detail'  => 'Plzeňský Prazdroj',
        'status'  => 'nomination',
        'project' => 'projects/plzensky-prazdroj',
        'url'     => ''
    ],
    [
        'year'    => '2021',
        'title'   => 'Kanceláře roku & Interiér roku',
        'detail'  => 'Hartmann-Rico',
        'status'  => 'nomination',
        'project' => 'projects/hartmann-rico',
        'url'     => ''
    ],
    [
        'year'    => '2018',
        'title'   => 'Designblok',
        'detail'  => 'Nejlepší novinka výrobce, autorský systém ONLY2',
        'status'  => 'winner',
        'project' => 'projects/ctpark-borska-pole',
        'url'     => 'https://interiordesign.net/designwire/10-highlights-from-prague-designblok-2018/'
    ]
];

$awardsList = [];
$items = ($rawAwards && $rawAwards->isNotEmpty()) ? $rawAwards : $defaultAwards;

$projectMap = [
    'direct'   => page('projects/direct-pojistovna'),
    'evropa'   => page('projects/volareza-restaurace-evropa'),
    'volareza' => page('projects/volareza-restaurace-evropa'),
    'prazdroj' => page('projects/plzensky-prazdroj'),
    'hartmann' => page('projects/hartmann-rico'),
    'ctpark'   => page('projects/ctpark-borska-pole'),
    'only'     => page('projects/ctpark-borska-pole'),
    'fcc'      => page('projects/fcc'),
    'ortho'    => page('projects/ortho-dent'),
];

foreach ($items as $idx => $item) {
    $yr = is_array($item) ? ($item['year'] ?? '') : (string)$item->year()->value();
    $tit = is_array($item) ? ($item['title'] ?? '') : (string)$item->title()->value();
    $det = is_array($item) ? ($item['detail'] ?? ($item['note'] ?? '')) : (string)($item->detail()->or($item->note())->value());
    $projSlug = is_array($item) ? ($item['project'] ?? '') : (string)$item->project()->value();
    $extUrl = is_array($item) ? ($item['url'] ?? '') : (string)$item->url()->value();

    $combinedText = mb_strtolower($tit . ' ' . $det . ' ' . (is_array($item) ? ($item['status'] ?? '') : ''));
    $isWinner = str_contains($combinedText, 'vítěz') || 
                str_contains($combinedText, 'vyhra') || 
                str_contains($combinedText, 'winner') || 
                str_contains($combinedText, '1. místo') || 
                str_contains($combinedText, 'nejlepší novinka');

    $cleanDetail = preg_replace('/^(vítěz|výhra|nominace)[,\s–-]*/iu', '', trim($det));
    if (empty($cleanDetail) && isset($defaultAwards[$idx]['detail'])) {
        $cleanDetail = $defaultAwards[$idx]['detail'];
    }

    $project = null;
    if (!empty($projSlug)) {
        $project = page($projSlug) ?? page('projects/' . trim($projSlug, '/'));
    }
    if (!$project) {
        foreach ($projectMap as $key => $p) {
            if ($p && (str_contains($combinedText, $key) || ($idx === 1 && $key === 'evropa') || ($idx === 4 && $key === 'ctpark'))) {
                $project = $p;
                break;
            }
        }
    }
    if (!$project && isset($defaultAwards[$idx]['project'])) {
        $project = page($defaultAwards[$idx]['project']);
    }

    $photo = $project ? ($project->cover()->toFile() ?? $project->images()->first()) : null;

    $awardsList[] = [
        'idx'          => $idx,
        'year'         => $yr,
        'title'        => $tit,
        'detail'       => $cleanDetail,
        'is_winner'    => $isWinner,
        'status_label' => $isWinner ? 'Vítěz' : 'Nominace',
        'project'      => $project,
        'photo'        => $photo,
        'url'          => $extUrl ?: ($project ? $project->url() : '')
    ];
}
?>

<section class="awards-section radius relative z__2" theme="dark" aria-labelledby="awards-heading" data-tabs="hoverable">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__4 mobile:gap__3">
		
		<div class="grid__12 gap__2 awards__grid">

			<!-- Levý panel: dynamicky měněný náhled projektu/nominace přizpůsobený výšce pravého panelu -->
			<div class="span__7 awards__media-col" data-pane-container>
				<div class="grid__stack">
					<?php foreach ($awardsList as $item) : ?>
						<div data-pane="award-<?= $item['idx'] ?>" class="awards__media-pane"<?= $item['idx'] === 0 ? ' data-active' : '' ?> data-tab-reveal>
							<a href="<?= esc($item['url']) ?>" class="awards__card" target="_blank" rel="noopener">
								<figure class="awards__figure img__radius">
									<?php if ($item['photo']) : ?>
										<?= snippet('atoms/Image', ['img' => $item['photo'], 'parallax' => false, 'reveal' => false, 'css' => 'img__radius']) ?>
									<?php else : ?>
										<div class="bg__dark img__radius w__100 h__100"></div>
									<?php endif ?>
								</figure>
								<div class="awards__media-overlay absolute inset__stretch grid gap__05 place__end-start inner__1">
                                    <?= snippet('atoms/Button', [
                                        'tag'   => 'span',
                                        'label' => $item['status_label'] . ' ' . $item['year'],
                                        'theme' => $item['is_winner'] ? 'acc' : 'invert-ghost',
                                        'hover' => false,
                                        'css'   => ''
                                    ]) ?>
									<h3 class="awards__media-title font__size__3 ff__heading"><?= esc($item['title']) ?></h3>
									<?php if (!empty($item['detail'])) : ?>
										<p class="awards__media-detail op__8"><?= esc($item['detail']) ?></p>
									<?php endif ?>
								</div>
							</a>
						</div>
					<?php endforeach ?>
				</div>
			</div>

			<!-- Pravý panel: nadpis a seznam nominací/ocenění -->
			<div class="grid gap__3 span__5 place__start-stretch awards__content-col">
				<div class="awards__header" data-scroll>
					<h2 id="awards-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
				</div>

				<ul class="awards__list" aria-label="Seznam ocenění a nominací">
					<?php foreach ($awardsList as $item) : ?>
						<li class="awards__item" data-tab="award-<?= $item['idx'] ?>"<?= $item['idx'] === 0 ? ' data-active' : '' ?>>
							<a class="awards__button flex gap__2" aria-label="<?= esc($item['year'] . ': ' . $item['title'] . ' – ' . $item['status_label'] . ' ' . $item['detail']) ?>">
								<span class="font__size__small"><?= esc($item['year']) ?></span>
								<span class="awards__item-title"><?= esc($item['title']) ?></span>
								<div class="font__size__small">
									<!-- <span class="awards__status-badge <?= $item['is_winner'] ? 'awards__status-badge--winner' : 'awards__status-badge--nomination' ?>">
										<?= null//esc($item['status_label']) ?>
									</span> -->
									<?php if (!empty($item['detail'])) : ?>
										<span class="awards__item-detail"><?= null//esc($item['detail']) ?><?= esc($item['status_label']) ?></span>
									<?php endif ?>
								</div>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>

	</div>
</section>
