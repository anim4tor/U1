<?php
$projectsPage = $page ?? page('projects');
$ctrlData = ($projectsPage && method_exists($projectsPage, 'controller')) ? $projectsPage->controller() : [];
?>
<?= snippet('templates/Projects/sections/filter', array_merge($ctrlData, array_filter([
    'isFiltered'       => $isFiltered ?? null,
    'filterIndustry'   => $filterIndustry ?? null,
    'filterSpace'      => $filterSpace ?? null,
    'filterSolution'   => $filterSolution ?? null,
    'filterProduction' => $filterProduction ?? null,
    'filterHash'       => $filterHash ?? null,
    'filterGeneric'    => $filterGeneric ?? null,
    'filterSearch'     => $filterSearch ?? null,
], fn($v) => $v !== null))) ?>
