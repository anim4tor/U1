<?php
/**
 * Sekce: Kde nás najdete (Showroomy Brno / Praha a fakturační údaje)
 * Vzor: v65 kontakt.html (data-blok="kde-nas-najdete")
 */

$locations = [
    [
        'title'   => 'Brno, sídlo a showroom',
        'address' => 'Nejedlého 373/1, 638 00 Brno-Lesná',
        'note'    => 'Budova bývalé pošty · Po–Pá 8:30–17:00',
        'map'     => 'https://maps.google.com/?q=Nejedlého+373/1,+Brno',
        'img'     => 'showroom-brno.webp'
    ],
    [
        'title'   => 'Praha, klientské studio',
        'address' => 'Na Valentince 3336/4, 150 00 Praha 5 – Smíchov',
        'note'    => 'Návštěvy po předchozí domluvě',
        'map'     => 'https://maps.google.com/?q=Na+Valentince+3336/4,+Praha',
        'img'     => 'showroom-praha.webp'
    ]
];
?>
<section class="sek cerna" aria-labelledby="show-h" data-blok="kde-nas-najdete">
  <div class="g zahlavi">
    <div class="zahlavi__nadpis">
      <h2 class="nadpis" id="show-h">Kde nás najdete</h2>
    </div>
  </div>

  <div class="g">
    <div class="mista">
      <?php foreach ($locations as $loc) : ?>
        <div class="misto">
          <div class="ph">
            <img 
              src="<?= url('site/assets/img/' . $loc['img']) ?>" 
              alt="<?= $loc['title'] ?>" 
              loading="lazy"
              onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'"
            >
          </div>
          <h3 class="perex"><?= $loc['title'] ?></h3>
          <address class="text"><?= $loc['address'] ?></address>
          <p class="popisek"><?= $loc['note'] ?></p>
          <div class="mt-1" style="display:flex; gap:calc(0.5*var(--u)); flex-wrap:wrap;">
            <a class="btn btn--obrys stitek" href="<?= $loc['map'] ?>" target="_blank" rel="noopener">
              Mapa &rarr;
            </a>
            <button class="btn stitek" type="button" data-contact-toggle="inquiry">
              Domluvit schůzku
            </button>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>

  <div class="g fakturace mt-4">
    <p class="pas__stitek stitek">Fakturační údaje</p>
    <p class="pas__obsah text">
      U1 s.r.o. · Nejedlého 373/1, 638 00 Brno-Lesná · IČO 26273179 · DIČ CZ26273179 · Krajský soud v Brně, oddíl C, vložka 41126
    </p>
  </div>
</section>

