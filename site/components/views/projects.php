<?= snippet('organisms/Html', [
	'page'           => $page,
	'industries'     => $industries ?? [],
	'spaces'         => $spaces ?? [],
	'filterIndustry' => $filterIndustry ?? null,
	'filterSpace'    => $filterSpace ?? null,
	'filterGeneric'  => $filterGeneric ?? null,
	'isFiltered'     => $isFiltered ?? false,
	'projects'       => $projects ?? null,
	'images'         => $images ?? null,
]) ?>