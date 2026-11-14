<?php
/**
 * Sekce: Týmy (TYP 1: Dělený blok týmů U1)
 * Vzor: v65 index.html (data-blok="tymy")
 */

$teamsBlocks = $page->teams()->toBlocks();
$introText = $teamsBlocks->filterBy('type', 'text')->first()?->text()->value()
    ?? 'Pod jednou střechou máme obchod, architekturu a design, projektové řízení a stavební realizaci. Nábytek na míru zajišťujeme s ověřenými truhláři. Každá profese přináší do projektu svou zkušenost. Návrh tak propojujeme s tím, jak interiér postavíme a vybavíme. Za celý dohodnutý rozsah vám odpovídáme jako jeden partner.';

$teamsList = [
    [
        'title' => 'Obchod',
        'desc'  => 'S vámi projdeme zadání a domluvíme rozsah spolupráce. Pro váš projekt zajistíme kanceláře na klíč, samostatný návrh nebo stavbu.',
        'anchor'=> 'obchod',
        'img'   => 'tym-2.webp'
    ],
    [
        'title' => 'Architektura a design',
        'desc'  => 'Navrhujeme uspořádání a podobu interiéru. Pracujeme s materiály, barvami a nábytkem v návaznosti na stavební realizaci.',
        'anchor'=> 'design',
        'img'   => 'hero-cinnosti.webp'
    ],
    [
        'title' => 'Projektové řízení',
        'desc'  => 'Propojujeme návrh, stavbu a dodávky vybavení. Koordinujeme profese, které se na realizaci podílejí.',
        'anchor'=> 'projektove-rizeni',
        'img'   => 'tym-1.webp'
    ],
    [
        'title' => 'Stavební realizace',
        'desc'  => 'Provádíme fit-out a rekonstrukce interiérů. Stavíme podle vlastních návrhů i projektů architektonických studií.',
        'anchor'=> 'realizace',
        'img'   => 'tym-3.webp'
    ]
];
?>
<section class="sek tepla del" aria-labelledby="tym-h" data-prepinac data-blok="tymy">
  <div class="g">
    <div class="del__text">
      <div>
        <h2 class="nadpis" id="tym-h">Týmy</h2>
        <p class="text mt-1" data-text data-vychozi="<?= htmlspecialchars($introText, ENT_QUOTES) ?>" aria-live="polite">
          <?= $introText ?>
        </p>
        <a class="odkaz text mt-1" href="<?= page('about') ? page('about')->url() . '#tym-h' : url('o-nas#tym-h') ?>">
          Poznejte náš tým <svg class="arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>

      <ul class="seznam" role="tablist" aria-label="Týmy">
        <?php foreach ($teamsList as $idx => $t) : ?>
          <li>
            <a 
              href="<?= page('about') ? page('about')->url() . '#' . $t['anchor'] : url('o-nas#' . $t['anchor']) ?>" 
              role="tab" 
              aria-selected="<?= $idx === 0 ? 'true' : 'false' ?>"
              data-desc="<?= htmlspecialchars($t['desc'], ENT_QUOTES) ?>"
            >
              <span class="perex"><?= $t['title'] ?></span>
              <svg class="go" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>

    <figure class="del__foto ph">
      <?php foreach ($teamsList as $idx => $t) : ?>
        <img 
          src="<?= url('site/assets/img/' . $t['img']) ?>" 
          alt="Tým <?= $t['title'] ?>" 
          <?= $idx > 0 ? 'hidden' : '' ?> 
          loading="lazy"
          onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'"
        >
      <?php endforeach ?>
    </figure>
  </div>
</section>
