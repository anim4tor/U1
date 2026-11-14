<?php
/**
 * Sekce: Ocenění a nominace
 * Vzor: v65 o-nas.html (data-blok="oceneni-a-nominace")
 */

$awards = [
    ['year' => '2025', 'title' => 'Kanceláře roku',            'desc' => 'vítěz, Direct pojišťovna'],
    ['year' => '2023', 'title' => 'Grand Prix architektů',     'desc' => 'nominace'],
    ['year' => '2022', 'title' => 'Interiér roku',             'desc' => 'nominace'],
    ['year' => '2021', 'title' => 'Interiér roku, Kanceláře',  'desc' => 'nominace'],
    ['year' => '2018', 'title' => 'Designblok',                'desc' => 'Nejlepší novinka výrobce, ONLY2']
];
?>
<section class="sek tepla pas pas--oceneni" aria-labelledby="oc-h" data-blok="oceneni-a-nominace">
  <div class="g">
    <h2 class="pas__stitek stitek" id="oc-h">Ocenění a nominace</h2>
    <ul class="pas__obsah oceneni-pas" style="list-style:none; padding:0; margin:0; display:flex; gap:calc(2*var(--gap)); flex-wrap:wrap;">
      <?php foreach ($awards as $item) : ?>
        <li style="display:grid; gap:calc(0.2*var(--u));">
          <span class="popisek acc"><?= $item['year'] ?></span>
          <span class="text" style="font-weight:600;"><?= $item['title'] ?></span>
          <span class="popisek"><?= $item['desc'] ?></span>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
</section>

