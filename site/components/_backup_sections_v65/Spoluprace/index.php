<?php
/**
 * Sekce: Spolupráce (3 cesty spolupráce)
 * Vzor: v65 index.html (data-blok="spoluprace")
 */

$paths = [
    [
        'badge' => 'Vše pod jednou smlouvou',
        'title' => 'Firmy a developeři',
        'desc'  => 'Od architektonické studie přes stavební úpravy a fit-out až po dodávku a montáž nábytku. Jeden partner, jedna odpovědnost za rozpočet i termín.',
        'url'   => page('services/kancelare-na-klic')?->url() ?? url('sluzby/kancelare-na-klic'),
        'main'  => true
    ],
    [
        'badge' => 'Realizace vašeho návrhu',
        'title' => 'Architekti a studia',
        'desc'  => 'Postavíme kanceláře podle vašeho projektu. Zajistíme stavební část, technické profese, akustiku a výrobu atypického nábytku s respektem k vašemu konceptu.',
        'url'   => page('services/realizace-pro-architekty')?->url() ?? url('sluzby/realizace-pro-architekty'),
        'main'  => false
    ],
    [
        'badge' => 'Vybavení a úpravy',
        'title' => 'Dílčí zadání',
        'desc'  => 'Potřebujete doplnit pracovní místa, vyřešit akustiku nebo vyměnit nábytek? Dodáme kancelářský nábytek našich značek Only1 a Only2 i prověřených evropských výrobců.',
        'url'   => page('services/kancelarsky-nabytek')?->url() ?? url('sluzby/kancelarsky-nabytek'),
        'main'  => false
    ]
];
?>
<section class="sek tepla spoluprace" aria-labelledby="cesty-h" data-blok="spoluprace">
  <div class="g">
    <h2 class="cesty__h stitek" id="cesty-h">Jak s námi můžete spolupracovat</h2>
    <div class="cesty">
      <?php foreach ($paths as $item) : ?>
        <a class="cesta <?= $item['main'] ? 'cesta--hlavni' : '' ?>" href="<?= $item['url'] ?>">
          <p class="stitek"><?= $item['badge'] ?></p>
          <div>
            <h3 class="perex"><?= $item['title'] ?></h3>
            <p class="text"><?= $item['desc'] ?></p>
          </div>
          <span class="cesta__sipka" aria-hidden="true">&rarr;</span>
        </a>
      <?php endforeach ?>
    </div>
  </div>
</section>

