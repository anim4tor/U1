<?php
/**
 * Sekce: Vybrané realizace (Karusel projektů s poměrem 3:4)
 * Vzor: v65 index.html (data-blok="vybrane-realizace")
 */

$projectsPage = page('projects');
$projects = $page->featuredprojects()->isNotEmpty()
    ? $page->featuredprojects()->toPages()
    : ($projectsPage ? $projectsPage->children()->listed()->limit(6) : null);
?>
<section class="sek cerna" aria-labelledby="real-h" data-karusel data-blok="vybrane-realizace">
  <div class="g zahlavi">
    <div class="zahlavi__nadpis">
      <h2 class="nadpis" id="real-h">Vybrané realizace</h2>
    </div>
    <div class="zahlavi__vpravo sipky">
      <?php if ($projectsPage) : ?>
        <a class="odkaz text zahlavi__odkaz" href="<?= $projectsPage->url() ?>">Všechny realizace &rarr;</a>
      <?php endif ?>
      <button class="kruh" type="button" data-prev aria-label="Předchozí">&larr;</button>
      <button class="kruh" type="button" data-next aria-label="Další">&rarr;</button>
    </div>
  </div>

  <div class="rail mt-3" data-rail>
    <?php if ($projects && $projects->count()) : ?>
      <?php foreach ($projects as $item) : 
        $img = $item->cover()->toFile() ?? $item->image();
        $location = $item->location()->or($item->city())->or('Česká republika')->html();
        $year = $item->year()->or($item->date()->toDate('Y'))->or('2024')->html();
        $category = $item->category()->or('Kanceláře')->html();
      ?>
        <article class="karta">
          <a href="<?= $item->url() ?>">
            <div class="ph ph--34">
              <?php if ($img) : ?>
                <img src="<?= $img->url() ?>" alt="<?= $item->title()->html() ?> – realizace U1" loading="lazy">
              <?php endif ?>
            </div>
            <p class="popisek"><?= $category ?> · <?= $location ?> · <?= $year ?></p>
            <h3 class="perex"><?= $item->title()->html() ?></h3>
          </a>
        </article>
      <?php endforeach ?>
    <?php endif ?>

    <?php if ($projectsPage) : ?>
      <article class="karta karta--vse">
        <a href="<?= $projectsPage->url() ?>">
          <div class="ph ph--34">
            <span class="perex">Všechny realizace &rarr;</span>
          </div>
          <p class="popisek">Archiv 200+ projektů</p>
          <h3 class="perex">Prohlédnout vše</h3>
        </a>
      </article>
    <?php endif ?>
  </div>
</section>

