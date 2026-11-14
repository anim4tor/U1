<?php
/**
 * Sekce: Články / Feed (Karusel novinek a článků, poměr 4:3)
 * Vzor: v65 index.html (data-blok="clanky")
 */

$feedPage = page('feed');
$posts = $feedPage ? $feedPage->children()->listed()->limit(6) : null;
?>
<section class="sek tepla" aria-labelledby="feed-h" data-karusel data-blok="clanky">
  <div class="g zahlavi">
    <div class="zahlavi__nadpis">
      <h2 class="nadpis" id="feed-h">Články</h2>
    </div>
    <div class="zahlavi__vpravo sipky">
      <?php if ($feedPage) : ?>
        <a class="odkaz text zahlavi__odkaz" href="<?= $feedPage->url() ?>">Všechny články &rarr;</a>
      <?php endif ?>
      <button class="kruh" type="button" data-prev aria-label="Předchozí">&larr;</button>
      <button class="kruh" type="button" data-next aria-label="Další">&rarr;</button>
    </div>
  </div>

  <div class="rail mt-3" data-rail>
    <?php if ($posts && $posts->count()) : ?>
      <?php foreach ($posts as $post) : 
        $img = $post->cover()->toFile() ?? $post->image();
        $date = $post->date()->toDate('d. m. Y') ?: date('d. m. Y');
        $tag = $post->category()->or('Článek')->html();
      ?>
        <article class="karta">
          <a href="<?= $post->url() ?>">
            <div class="ph">
              <?php if ($img) : ?>
                <img src="<?= $img->url() ?>" alt="<?= $post->title()->html() ?>" loading="lazy">
              <?php endif ?>
            </div>
            <p class="popisek"><?= $tag ?> · <?= $date ?></p>
            <h3 class="perex"><?= $post->title()->html() ?></h3>
          </a>
        </article>
      <?php endforeach ?>
    <?php else : ?>
      <article class="karta">
        <a href="<?= url('feed') ?>">
          <div class="ph">
            <img src="<?= url('site/assets/img/article-1.webp') ?>" alt="Článek U1" onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'">
          </div>
          <p class="popisek">Téma · 15. 10. 2026</p>
          <h3 class="perex">Kolik m² kanceláře potřebuje jeden zaměstnanec?</h3>
        </a>
      </article>
      <article class="karta">
        <a href="<?= url('feed') ?>">
          <div class="ph">
            <img src="<?= url('site/assets/img/article-2.webp') ?>" alt="Článek U1" onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'">
          </div>
          <p class="popisek">Trendy · 02. 10. 2026</p>
          <h3 class="perex">Akustika v open space: jak zkrotit hluk bez stavění zdí</h3>
        </a>
      </article>
      <article class="karta">
        <a href="<?= url('feed') ?>">
          <div class="ph">
            <img src="<?= url('site/assets/img/article-3.webp') ?>" alt="Článek U1" onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'">
          </div>
          <p class="popisek">Rozhovor · 18. 09. 2026</p>
          <h3 class="perex">Nábytek Only2: cesta od prototypu k ocenění na Designbloku</h3>
        </a>
      </article>
    <?php endif ?>
  </div>
</section>

