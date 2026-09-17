<?php
/**
 * Positions template — "Volné pozice"
 * Layout mirroring Projects: hero + grid of job cards
 */

$jobs = $page->children()->listed();
?>
<?php include __DIR__ . '/sections/1_hero.php' ?>
<?php include __DIR__ . '/sections/2_list.php' ?>
