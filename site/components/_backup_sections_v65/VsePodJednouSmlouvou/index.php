<?php
/**
 * Sekce: Vše pod jednou smlouvou
 * Vzor: v65 sluzby.html (data-blok="vse-pod-jednou-smlouvou")
 */

$steps = [
    [
        'num'   => '01',
        'title' => 'Návrh',
        'desc'  => 'Navrhneme interiér podle toho, jak vaše firma pracuje a co od prostoru potřebuje.'
    ],
    [
        'num'   => '02',
        'title' => 'Stavba a technologie',
        'desc'  => 'Zajistíme stavební realizaci a koordinaci technických profesí v dohodnutém rozsahu.'
    ],
    [
        'num'   => '03',
        'title' => 'Nábytek Only1, Only2 a atypy na míru',
        'desc'  => 'Atypický a kancelářský nábytek připravujeme s ověřenými truhláři pro konkrétní interiér.'
    ],
    [
        'num'   => '04',
        'title' => 'Předání a péče',
        'desc'  => 'Hotový interiér vám předáme s veškerou dokumentací, zárukami a garancí následného servisu.'
    ]
];
?>
<section class="sek cerna smlouva" aria-labelledby="smlouva-h" data-blok="vse-pod-jednou-smlouvou">
  <div class="g zahlavi">
    <div class="zahlavi__nadpis">
      <h2 class="nadpis" id="smlouva-h">Vše pod jednou smlouvou</h2>
    </div>
    <p class="zahlavi__vpravo text">
      Od architektonického návrhu po vybavení jednáte s jedním odpovědným partnerem. Celý dohodnutý rozsah zastřešujeme my.
    </p>
  </div>

  <div class="g mt-3">
    <ol class="osa osa--4">
      <?php foreach ($steps as $step) : ?>
        <li class="krok">
          <p class="stitek krok__cislo"><?= $step['num'] ?></p>
          <h3 class="perex"><?= $step['title'] ?></h3>
          <p class="text"><?= $step['desc'] ?></p>
        </li>
      <?php endforeach ?>
    </ol>
  </div>
</section>

