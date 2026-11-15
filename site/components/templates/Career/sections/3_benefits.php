<?php
/**
 * Sekce: Proč pracovat u nás (v65 kariera.html)
 * 3 benefitní karty v našem designovém systému
 */
$heading = $page->benefitsHeading()->or('Proč pracovat u nás');
$benefits = isset($benefits) ? $benefits : $page->benefits()->toStructure();

if ($benefits->isEmpty() || ($benefits->first() && $benefits->first()->title()->isEmpty())) {
    $benefits = [
        [
            'num'   => '01',
            'title' => 'Propojení profesí',
            'text'  => 'Architektura, stavba a projektové řízení jsou součástí jedné firmy. Jejich práce se potkává na společných projektech.'
        ],
        [
            'num'   => '02',
            'title' => 'Od návrhu k realizaci',
            'text'  => 'Zajišťujeme návrh interiéru i jeho provedení. K našim projektům patří také kompletní kanceláře na klíč.'
        ],
        [
            'num'   => '03',
            'title' => 'Různé typy interiérů',
            'text'  => 'Vedle kanceláří pracujeme na klinikách a gastronomických interiérech. Konkrétní práci ukazujeme v realizacích.'
        ]
    ];
}
?>

<section class="benefits-section radius relative z__2" theme="dark" aria-labelledby="benefits-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid__4 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="benefits-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
			</div>
		</div>

		<ol class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<?php $idx = 1; ?>
			<?php foreach ($benefits as $item) : ?>
				<?php 
				$num = is_array($item) ? ($item['num'] ?? str_pad($idx, 2, '0', STR_PAD_LEFT)) : str_pad($idx, 2, '0', STR_PAD_LEFT);
				$title = is_array($item) ? ($item['title'] ?? '') : $item->title()->value();
				$text = is_array($item) ? ($item['text'] ?? '') : $item->text()->value();
				$idx++;
				?>
				<li class="grid place__start-stretch gap__1 border__top inner-t__1">
					<span class="label font__size__small color__acc"><?= esc($num) ?></span>
					<h3 class="font__size__3" data-reveal-text><?= esc($title) ?></h3>
					<p class="font__size__default op__7" data-reveal-text="lines"><?= esc($text) ?></p>
				</li>
			<?php endforeach ?>
		</ol>

	</div>
</section>
