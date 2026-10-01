<?php
$projectsPage = $page ?? page('projects');
$ctrlData = ($projectsPage && method_exists($projectsPage, 'controller')) ? $projectsPage->controller() : [];
?>
<?= snippet('templates/globals/Hero/list', array_merge($ctrlData, array_filter([
    'isFiltered'       => $isFiltered ?? null,
    'filterIndustry'   => $filterIndustry ?? null,
    'filterSpace'      => $filterSpace ?? null,
    'filterSolution'   => $filterSolution ?? null,
    'filterProduction' => $filterProduction ?? null,
    'filterHash'       => $filterHash ?? null,
    'filterYear'       => $filterYear ?? null,
    'filterGeneric'    => $filterGeneric ?? null,
    'filterSearch'     => $filterSearch ?? null,
    'activeTokens'     => $activeTokens ?? null,
    'searchable'       => true,
    'industries'       => $industries ?? null,
    'spaces'           => $spaces ?? null,
    'solutions'        => $solutions ?? null,
    'productions'      => $productions ?? null,
    'hashes'           => $hashes ?? null,
    'years'            => $years ?? null,
    'images'           => $images ?? null,
    'projects'         => $projects ?? null
], fn($v) => $v !== null))) ?>