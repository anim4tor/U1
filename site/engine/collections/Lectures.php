<?php
return function () {
	// $lectures = [
	// 	[
	// 		'slug' => 'hatha',
	// 		'name' => 'Hatha',
	// 		'feel' => 'Classic, on the wave of your own breath'
	// 	],
	// 	[
	// 		'slug' => 'ashtanga',
	// 		'name' => 'Ashtanga',
	// 		'feel' => 'Meditation in motion, with perspective'
	// 	],
	// 	[
	// 		'slug' => 'power',
	// 		'name' => 'Power',
	// 		'feel' => 'Classic, on the wave of your own breath'
	// 	],
	// 	[
	// 		'slug' => 'vinyasa',
	// 		'name' => 'Vinyasa',
	// 		'feel' => 'In the balance of strength and flexibility'
	// 	],
	// 	[
	// 		'slug' => 'yin-Yang',
	// 		'name' => 'Yin-Yang',
	// 		'feel' => 'Gently, for a healthy back'
	// 	],
	// 	[
	// 		'slug' => 'relax',
	// 		'name' => 'Relax',
	// 		'feel' => 'Purely and calmly'
	// 	],
	// 	[
	// 		'slug' => 'yin',
	// 		'name' => 'Yin',
	// 		'feel' => 'Subtle, gentle, yet profoundly deep'
	// 	],
	// 	[
	// 		'slug' => 'anti-age',
	// 		'name' => 'Anti-age',
	// 		'feel' => 'Age is just a number, movement is life'
	// 	],
	// 	[
	// 		'slug' => 'acro',
	// 		'name' => 'Acro',
	// 		'feel' => 'Trust and cooperation. And upside down'
	// 	],
	// 	[
	// 		'slug' => 'gravid',
	// 		'name' => 'Gravid',
	// 		'feel' => 'Feeling good for both of you'
	// 	]
		
	// ];

	// $file = 'public/content/2_lectures/data.json';
	// file_put_contents($file, json_encode($lectures));
	// $json = file_get_contents($file);

	// return json_decode($json, true);
	return page('lekce')->children()->listed();
};


