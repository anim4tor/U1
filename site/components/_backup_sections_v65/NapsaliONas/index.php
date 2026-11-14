<?php
/**
 * Sekce: Napsali o nás (Pás s logy médií / partnerů)
 * Vzor: v65 index.html (data-blok="napsali-o-nas")
 */

$mediaList = [
    ['name' => 'Forbes',              'file' => 'logo-1.png'],
    ['name' => 'Novinky.cz',          'file' => 'logo-2.png'],
    ['name' => 'E15',                 'file' => 'logo-3.png'],
    ['name' => 'Hospodářské noviny',  'file' => 'logo-4.png'],
    ['name' => 'CzechCrunch',         'file' => 'logo-5.png']
];
?>
<section class="sek tepla pas" aria-label="Napsali o nás" data-blok="napsali-o-nas">
  <div class="g">
    <p class="pas__stitek stitek">Napsali o nás</p>
    <div class="pas__obsah">
      <?php foreach ($mediaList as $item) : ?>
        <img 
          src="<?= url('site/assets/img/' . $item['file']) ?>" 
          alt="<?= $item['name'] ?>" 
          title="<?= $item['name'] ?>"
          loading="lazy"
          onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';"
        >
        <span class="stitek muted" style="display:none;"><?= $item['name'] ?></span>
      <?php endforeach ?>
    </div>
  </div>
</section>

