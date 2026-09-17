<?php
$showrooms = [
	[
		'city'       => 'Brno — Lesná',
		'tag'        => 'Sídlo & Showroom',
		'region'     => 'Morava',
		'address'    => 'Nejedlého 373/1, 638 00 Brno-Lesná',
		'image'      => 'showroom_brno.png',
	],
	[
		'city'       => 'Praha — Smíchov',
		'tag'        => 'Showroom',
		'region'     => 'Čechy',
		'address'    => 'Na Valentince 3336/4, 150 00 Praha-Smíchov',
		'image'      => 'showroom_praha.jpg',
	],
];
?>

<?= snippet('templates/globals/Testimonials/fullscreen', [
	'items'   => $showrooms,
	'snippet' => 'molecules/Showroom/featured',
	'theme'   => 'dark'
]) ?>
