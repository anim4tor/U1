<?php
/**
 * Sekce: Pobočky a showroomy (v65 kontakt.html)
 * 2 showroom karty (Brno, Praha) + fakturační údaje
 */
$heading = $page->locationsHeading()->or('Kde nás najdete');
$billingLabel = $page->billingLabel()->or('Fakturační údaje');
$billingText = $page->billingText()->or('U1 s.r.o. · Nejedlého 373/1, 638 00 Brno-Lesná · IČO 26273179 · DIČ CZ26273179 · Krajský soud v Brně, oddíl C, vložka 41126');

$locations = [];
if ($page->locations()->isNotEmpty()) {
    foreach ($page->locations()->toStructure() as $loc) {
        $img = null;
        if ($loc->image()->isNotEmpty()) {
            $img = $loc->image()->toFile();
        }
        if (!$img) {
            $cleanTitle = strtolower($loc->title()->value());
            if (str_contains($cleanTitle, 'brno')) {
                $img = $page->image('showroom_brno.png') ?? 'showroom_brno.png';
            } elseif (str_contains($cleanTitle, 'praha')) {
                $img = $page->image('showroom_praha.jpg') ?? 'showroom_praha.jpg';
            }
        }

        $locations[] = [
            'title'   => $loc->title()->value(),
            'address' => $loc->address()->value(),
            'note'    => $loc->note()->value(),
            'mapUrl'  => $loc->mapurl()->value(),
            'image'   => $img
        ];
    }
}

if (empty($locations)) {
    $locations = [
        [
            'title'   => 'Brno, sídlo a showroom',
            'address' => 'Nejedlého 373/1, 638 00 Brno-Lesná',
            'note'    => 'Budova bývalé pošty.',
            'mapUrl'  => 'https://maps.google.com/?q=Nejedl%C3%A9ho+373/1,+Brno',
            'image'   => $page->image('showroom_brno.png') ?? 'showroom_brno.png'
        ],
        [
            'title'   => 'Praha',
            'address' => 'Na Valentince 3336/4, 150 00 Praha 5, Smíchov',
            'note'    => 'Showroom Praha',
            'mapUrl'  => 'https://maps.google.com/?q=Na+Valentince+3336/4,+Praha',
            'image'   => $page->image('showroom_praha.jpg') ?? 'showroom_praha.jpg'
        ]
    ];
}
?>

<section class="locations-section radius relative z__2" theme="dark" aria-labelledby="locations-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid gap__1" data-scroll>
			<h2 id="locations-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
		</div>

		<div class="grid__2 gap__2 mobile:grid__1" data-scroll>
			<?php foreach ($locations as $loc) : ?>
				<div class="grid gap__1 align__start">
					<div class="aspect__4/3 img__radius relative no__overflow" data-reveal-image>
						<?php if (is_object($loc['image'])) : ?>
							<?= snippet('atoms/Image', ['img' => $loc['image'], 'reveal' => false, 'css' => 'aspect__4/3 img__radius']) ?>
						<?php elseif (is_string($loc['image'])) : ?>
							<?= snippet('atoms/Image', ['url' => $loc['image'], 'reveal' => false, 'css' => 'aspect__4/3 img__radius']) ?>
						<?php else : ?>
							<div class="aspect__4/3 bg__light/10 img__radius flex align__center justify__center op__5 font__size__small">
								<?= esc($loc['title']) ?>
							</div>
						<?php endif ?>
					</div>

					<div class="grid gap__05">
						<h3 class="font__size__3" data-reveal-text data-split-ignore><?= esc($loc['title']) ?></h3>
						<p class="font__size__default op__8"><?= esc($loc['address']) ?></p>
						<?php if (!empty($loc['note'])) : ?>
							<p class="font__size__small op__5"><?= esc($loc['note']) ?></p>
						<?php endif ?>
					</div>

					<div class="flex gap__05 flex__wrap align__center">
						<?php if (!empty($loc['mapUrl'])) : ?>
							<?= snippet('atoms/Button', [
								'url'    => $loc['mapUrl'],
								'label'  => 'Mapa',
								'icon'   => 'arrow-top-right',
								'theme'  => 'invert-ghost',
								'hover'  => 'invert',
								'target' => true
							]) ?>
						<?php endif ?>
						<?= snippet('atoms/Button', [
							'label' => 'Domluvit schůzku',
							'theme' => 'invert',
							'hover' => 'invert-ghost',
							'node'  => 'data-contact-toggle="contact" type="button"'
						]) ?>
					</div>
				</div>
			<?php endforeach ?>
		</div>

		<?php if (!empty($billingText)) : ?>
			<div class="border__top inner-t__2 flex align__baseline justify__space-between gap__2 mobile:grid__1 mobile:gap__05" data-scroll>
				<span class="label"><?= esc($billingLabel) ?></span>
				<p class="">
					<?= esc($billingText) ?>
				</p>
			</div>
		<?php endif ?>

	</div>
</section>
