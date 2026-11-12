<?php
$title = 'Jak s námi můžete spolupracovat';
$items = [
    [
        'badge' => 'Vše pod jednou smlouvou',
        'title' => 'Kanceláře na klíč',
        'text' => 'Navrhneme, postavíme a vybavíme. Za celý projekt odpovídáme my a vy řešíte všechno s jedním týmem.',
        'url' => url('services'),
        'main' => true
    ],
    [
        'badge' => 'Jen návrh',
        'title' => 'Návrh interiéru kanceláře',
        'text' => 'Naši architekti připraví dispozici, materiály i dokumentaci. Stavět pak můžete s námi, nebo s jinou firmou.',
        'url' => url('services'),
        'main' => false
    ],
    [
        'badge' => 'Podle vašeho architekta',
        'title' => 'Realizace pro architekty',
        'text' => 'Máte návrh od jiného studia? Postavíme ho a vybavíme nábytkem na míru.',
        'url' => url('services'),
        'main' => false
    ]
];
?>
<section class="cooperation radius" theme="light" data-scroll>
	<div class="grid place__start-stretch gap__2 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="grid gap__1 span__4" data-scroll>
			<?= snippet('atoms/Label', ['text' => $title]) ?>
		</div>
		<div class="grid__3 gap__2 span__4 mobile:grid__1 inner-t__2" data-scroll>
			<?php foreach ($items as $item): ?>
				<a href="<?= $item['url'] ?>" class="grid place__space-between-stretch gap__2 inner__2 radius border__subtle <?= $item['main'] ? 'bg__dark/40' : '' ?>" <?= $item['main'] ? 'theme="invert"' : '' ?>>
					<div class="label upper font__size__small op__6"><?= $item['badge'] ?></div>
					<div class="grid gap__05 inner-y__1">
						<h3 class=""><?= $item['title'] ?></h3>
						<p class="font__size__default op__7"><?= $item['text'] ?></p>
					</div>
					<div class="flex justify__end align__center inner-t__05">
						<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span>
					</div>
				</a>
			<?php endforeach ?>
		</div>
	</div>
</section>

