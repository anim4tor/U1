<?php
/**
 * Sekce: Jak pracujeme (5 kroků procesu)
 * Vzor: v65 index.html (data-blok="jak-pracujeme")
 */

$steps = [
    [
        'num'   => '01',
        'title' => 'Zadání',
        'desc'  => 'Nejdříve zjistíme, jak lidé ve vaší firmě pracují, co v současném prostoru chybí a jaké máte plány růstu. Výstupem je zadávací dokument a prostorový program.',
        'img'   => 'process-1.webp'
    ],
    [
        'num'   => '02',
        'title' => 'Návrh',
        'desc'  => 'Architektonická studie, dispoziční řešení a materiálový koncept. Společně ladíme dispozice, akustiku, osvětlení i výběr nábytku.',
        'img'   => 'process-2.webp'
    ],
    [
        'num'   => '03',
        'title' => 'Rozpočet a projekt',
        'desc'  => 'Detailní položkový rozpočet s garantovanou cenou a prováděcí projektová dokumentace. Všechny profese zkoordinované před zahájením stavby.',
        'img'   => 'process-3.webp'
    ],
    [
        'num'   => '04',
        'title' => 'Realizace',
        'desc'  => 'Stavební práce, technické instalace, příčky, podlahy i akustické prvky. Projektový manažer řídí harmonogram a denně kontroluje kvalitu.',
        'img'   => 'process-4.webp'
    ],
    [
        'num'   => '05',
        'title' => 'Předání a provoz',
        'desc'  => 'Montáž nábytku, kolaudace a předání hotových kanceláří. Zůstáváme k dispozici pro záruční servis, úpravy i další rozvoj vašich prostor.',
        'img'   => 'process-5.webp'
    ]
];
?>
<section class="sek bila proc" aria-labelledby="proc-h" data-proc data-blok="jak-pracujeme">
  <div class="g zahlavi">
    <div class="zahlavi__nadpis">
      <h2 class="nadpis" id="proc-h">Jak pracujeme</h2>
    </div>
    <div class="zahlavi__vpravo text">
      Pět kroků od první schůzky po nastěhování. Každý krok má jasný výstup a garanci.
    </div>
  </div>

  <div class="proc__rada mt-3" role="tablist">
    <?php foreach ($steps as $idx => $step) : ?>
      <button 
        class="proc__krok" 
        role="tab" 
        aria-selected="<?= $idx === 0 ? 'true' : 'false' ?>" 
        data-krok="<?= $step['num'] ?>"
        data-desc="<?= htmlspecialchars($step['desc'], ENT_QUOTES) ?>"
        type="button"
      >
        <div class="ph">
          <img 
            src="<?= url('site/assets/img/' . $step['img']) ?>" 
            alt="Krok <?= $step['num'] ?>: <?= $step['title'] ?>" 
            loading="lazy"
            onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'"
          >
        </div>
        <div class="proc__meta">
          <span class="popisek"><?= $step['num'] ?></span>
          <h3 class="perex"><?= $step['title'] ?></h3>
        </div>
      </button>
    <?php endforeach ?>
  </div>

  <div class="g">
    <p class="proc__text text" data-proc-text>
      <?= $steps[0]['desc'] ?>
    </p>
  </div>
</section>

