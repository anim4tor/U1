<?php
/**
 * Sekce: Služby (TYP 1: Dělený blok s přepínáním služeb)
 * Vzor: v65 index.html (data-blok="sluzby")
 */

$servicesPage = page('services');

$defaultServices = [
    [
        'title' => 'Kanceláře na klíč',
        'desc'  => 'Navrhneme, postavíme a vybavíme vaše kanceláře. Za celý projekt odpovídáme my.',
        'url'   => page('services/kancelare-na-klic')?->url() ?? url('sluzby/kancelare-na-klic'),
        'img'   => 'services-1.webp'
    ],
    [
        'title' => 'Návrh interiérů',
        'desc'  => 'Navrhneme, jak bude vaše kancelář uspořádaná a jak bude vypadat.',
        'url'   => page('services/navrh-interieru')?->url() ?? url('sluzby/navrh-interieru'),
        'img'   => 'services-2.webp'
    ],
    [
        'title' => 'Projektové řízení',
        'desc'  => 'Koordinujeme práci profesí, které váš interiér staví a vybavují.',
        'url'   => page('services/projektove-rizeni')?->url() ?? url('sluzby/projektove-rizeni'),
        'img'   => 'services-3.webp'
    ],
    [
        'title' => 'Fit-out a stavební úpravy',
        'desc'  => 'Postavíme nové kanceláře nebo přestavíme stávající. Pracujeme podle vlastního i externího návrhu.',
        'url'   => page('services/fit-out')?->url() ?? url('sluzby/fit-out'),
        'img'   => 'services-4.webp'
    ],
    [
        'title' => 'Nábytek na míru',
        'desc'  => 'Nábytek na míru pro konkrétní prostor, od pracovních míst po recepci.',
        'url'   => page('services/nabytek-na-miru')?->url() ?? url('sluzby/nabytek-na-miru'),
        'img'   => 'services-5.webp'
    ],
    [
        'title' => 'Realizace pro architekty',
        'desc'  => 'Postavíme interiér podle vašeho návrhu. Autorství zůstává vašemu studiu.',
        'url'   => page('services/realizace-pro-architekty')?->url() ?? url('sluzby/realizace-pro-architekty'),
        'img'   => 'services-6.webp'
    ]
];

$items = $defaultServices;
?>
<section class="sek cerna del" aria-labelledby="res-h" data-prepinac data-blok="sluzby">
  <div class="g">
    <div class="del__text">
      <div>
        <h2 class="nadpis" id="res-h">Služby</h2>
        <p class="text mt-1" data-text data-vychozi="<?= htmlspecialchars($items[0]['desc'], ENT_QUOTES) ?>" aria-live="polite">
          <?= $items[0]['desc'] ?>
        </p>
        <a class="odkaz text mt-1" href="<?= $servicesPage ? $servicesPage->url() : url('sluzby') ?>">
          Všechny služby <svg class="arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>

      <ul class="seznam" role="tablist" aria-label="Služby">
        <?php foreach ($items as $idx => $item) : ?>
          <li>
            <a 
              href="<?= $item['url'] ?>" 
              role="tab" 
              aria-selected="<?= $idx === 0 ? 'true' : 'false' ?>"
              data-desc="<?= htmlspecialchars($item['desc'], ENT_QUOTES) ?>"
            >
              <span class="perex"><?= $item['title'] ?></span>
              <svg class="go" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>

    <figure class="del__foto ph">
      <?php foreach ($items as $idx => $item) : ?>
        <img 
          src="<?= url('site/assets/img/' . $item['img']) ?>" 
          alt="<?= $item['title'] ?>" 
          <?= $idx > 0 ? 'hidden' : '' ?> 
          loading="lazy"
          onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'"
        >
      <?php endforeach ?>
    </figure>
  </div>
</section>
