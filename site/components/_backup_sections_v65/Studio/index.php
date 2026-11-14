<?php
/**
 * Sekce: Studio (O studiu U1, výrok a statistiky)
 * Vzor: v65 index.html (data-blok="blok")
 */

$aboutBlocks = $page->about()->toBlocks();
$vyrok = $aboutBlocks->filterBy('type', 'text')->first()?->text()->value() 
    ?? 'Nejdřív chceme vědět, jak u vás lidé pracují. Pak přijde návrh a realizace kanceláří a kancelářský nábytek na míru. Pracujeme z Brna a Prahy po celém Česku.';

$figures = $page->aboutfigures()->toStructure();
$defaultFigures = [
    ['feature' => '200+', 'label' => 'PROJEKTŮ'],
    ['feature' => '90+',  'label' => 'LIDÍ V TÝMECH'],
    ['feature' => '25+',  'label' => 'LET ZKUŠENOSTÍ']
];
?>
<section class="sek bila" aria-labelledby="studio-h" data-blok="studio">
  <div class="g">
    <div class="c1-8">
      <p class="stitek-sek" id="studio-h">
        <span class="ctverec" aria-hidden="true"></span>
        <span class="stitek">Studio U1</span>
      </p>
      <p class="vyrok mt-1"><?= $vyrok ?></p>
      <?php if ($aboutPage = page('about')) : ?>
        <a class="odkaz text mt-1" href="<?= $aboutPage->url() ?>">Více o nás &rarr;</a>
      <?php endif ?>
    </div>
  </div>

  <div class="g mt-4">
    <div class="cisla">
      <?php if ($figures->isNotEmpty()) : ?>
        <?php foreach ($figures as $fig) : 
          $val = $fig->feature()->html();
          if (!str_contains($val, '+')) $val .= '+';
        ?>
          <div>
            <span class="popisek"><?= $fig->label()->html() ?></span>
            <b class="nadpis"><?= $val ?></b>
          </div>
        <?php endforeach ?>
      <?php else : ?>
        <?php foreach ($defaultFigures as $fig) : ?>
          <div>
            <span class="popisek"><?= $fig['label'] ?></span>
            <b class="nadpis"><?= $fig['feature'] ?></b>
          </div>
        <?php endforeach ?>
      <?php endif ?>
    </div>
  </div>
</section>

