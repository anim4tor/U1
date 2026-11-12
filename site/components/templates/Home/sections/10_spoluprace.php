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
	<div class="grid place__start-stretch gap__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="grid gap__1 span__4" data-scroll>
			<?= snippet('atoms/Label', ['text' => $title]) ?>
		</div>
		<div class="grid__3 gap__2 span__4 mobile:grid__1" data-scroll>
			<?php foreach ($items as $item): ?>
				<a href="<?= $item['url'] ?>" class="grid place__space-between-stretch gap__1 inner__2 radius border__subtle" <?= $item['main'] ? 'theme="dark"' : 'theme="invert"' ?>>
					<div class="grid gap__2">
						<?= snippet('atoms/Label', [
							'text' => $item['badge'],
							'css' => $item['main'] ? 'color__acc op__10' : ''
						]) ?>
						<div class="grid gap__05">
							<h3 class=""><?= $item['title'] ?></h3>
							<p class="font__size__default op__7"><?= $item['text'] ?></p>
						</div>
					</div>    
					<div class="flex justify__end align__center inner-t__05">
						<?= snippet('atoms/Button', [
							'label' => false,
							'icon'  => 'arrow-right',
							'css'   => '',
							'theme' => $item['main'] ? 'invert-ghost' : 'ghost',
							'hover' => $item['main'] ? 'invert' : 'dark',
							'tag'   => 'span',
							'node'  => 'tabindex="-1" aria-hidden="true"'
						]) ?>
					</div>
				</a>
			<?php endforeach ?>
		</div>
	</div>
</section>


