<?php
/**
 * Sekce: Na čem stavíme (v65 o-nas.html)
 * Tmavá sekce se 3 pilíři v našem designovém systému
 */
$heading = $page->valuesHeading()->or('Na čem stavíme');
$values = $page->values()->toStructure();

if ($values->isEmpty()) {
    $values = [
        [
            'num'    => '01',
            'title'  => 'Odpovědnost za celek',
            'detail' => 'U kanceláří na klíč propojujeme návrh, stavbu a vybavení pod jednou smlouvou. Za dohodnutý rozsah odpovídáme jako jeden partner.'
        ],
        [
            'num'    => '02',
            'title'  => 'Znalost provedení',
            'detail' => 'Máme vlastní architekty, projektové manažery a stavební tým. Jejich zkušenosti propojujeme při realizaci konkrétního interiéru.'
        ],
        [
            'num'    => '03',
            'title'  => 'Respekt k autorství',
            'detail' => 'Stavíme také podle projektů architektonických studií. Jejich autorství uvádíme a naši práci popisujeme podle skutečného rozsahu.'
        ]
    ];
}
?>

<section class="values-section radius relative z__2" theme="dark" aria-labelledby="values-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid__4 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="values-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
			</div>
		</div>

		<ol class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<?php $idx = 1; ?>
			<?php foreach ($values as $item) : ?>
				<?php 
				$num = is_array($item) ? ($item['num'] ?? str_pad($idx, 2, '0', STR_PAD_LEFT)) : str_pad($item->step()->or($idx), 2, '0', STR_PAD_LEFT);
				$title = is_array($item) ? ($item['title'] ?? '') : $item->value()->value();
				$detail = is_array($item) ? ($item['detail'] ?? '') : strip_tags($item->detail()->value());
				$idx++;
				?>
				<li class="grid place__start-stretch gap__1 border__top inner-t__1">
					<span class="label font__size__small color__acc"><?= esc($num) ?></span>
					<h3 class="font__size__3" data-reveal-text><?= esc($title) ?></h3>
					<p class="font__size__default op__7" data-reveal-text="lines"><?= esc($detail) ?></p>
				</li>
			<?php endforeach ?>
		</ol>

	</div>
</section>
