<?php
/**
 * Sekce: Proč pracovat u nás
 * Vzor: v65 kariera.html (data-blok="proc-pracovat-u-nas")
 */

$reasons = [
    [
        'title' => 'Propojení profesí',
        'desc'  => 'Architektura, stavba a projektové řízení jsou součástí jedné firmy. Jejich práce se potkává na společných projektech bez zbytečných bariér.'
    ],
    [
        'title' => 'Od návrhu k realizaci',
        'desc'  => 'Zajišťujeme návrh interiéru i jeho fyzické provedení. To, co vymyslíte na papíře, uvidíte skutečně vyrůst a stát.'
    ],
    [
        'title' => 'Různé typy interiérů',
        'desc'  => 'Vedle prestižních kanceláří pracujeme na klinikách, showroomech a gastronomických interiérech s důrazem na špičkový design.'
    ],
    [
        'title' => 'Vlastní autorský nábytek',
        'desc'  => 'Vyvíjíme oceněné nábytkové řady Only1 a Only2 a spolupracujeme s nejlepšími truhláři a designéry v republice.'
    ]
];
?>
<section class="sek cerna" aria-labelledby="proc-h" data-blok="proc-pracovat-u-nas">
  <div class="g zahlavi">
    <div class="zahlavi__nadpis">
      <h2 class="nadpis" id="proc-h">Proč pracovat u nás</h2>
    </div>
    <p class="zahlavi__vpravo text">
      Rosteme a hledáme talentované lidi, kteří chtějí měnit pracovní prostředí k lepšímu.
    </p>
  </div>

  <div class="g mt-3">
    <div class="duvody">
      <?php foreach ($reasons as $item) : ?>
        <article class="duvod">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <path d="M5 13l4 4L19 7"/>
          </svg>
          <h3 class="perex"><?= $item['title'] ?></h3>
          <p class="text"><?= $item['desc'] ?></p>
        </article>
      <?php endforeach ?>
    </div>
  </div>
</section>

