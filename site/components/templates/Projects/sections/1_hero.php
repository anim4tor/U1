<?= snippet('templates/globals/Hero/list', [
    'isFiltered'       => $isFiltered ?? false,
    'filterIndustry'   => $filterIndustry ?? null,
    'filterSpace'      => $filterSpace ?? null,
    'filterGeneric'    => $filterGeneric ?? null,
    'industries'       => $industries ?? [],
    'spaces'           => $spaces ?? [],
    'images'           => $images ?? null,
    'projects'         => $projects ?? null
]) ?>