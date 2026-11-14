<?php
/**
 * Sekce: Výzva / CTA (Společný závěrečný blok před patičkou)
 * Vzor: v65 index.html (data-blok="vyzva")
 */

$contactPerson = $site->contact_person()->toFile() ?? null;
?>
<section class="sek cerna vyzva" aria-labelledby="vyzva-h" data-blok="vyzva">
  <div class="g">
    <div class="vyzva__foto">
      <?php if ($contactPerson) : ?>
        <img src="<?= $contactPerson->url() ?>" alt="Kontakt U1" loading="lazy">
      <?php else : ?>
        <img src="<?= url('site/assets/img/contact-person.webp') ?>" alt="Kontakt U1" loading="lazy" onerror="this.src='<?= url('site/assets/img/hero-placeholder.jpg') ?>'">
      <?php endif ?>
    </div>

    <div class="vyzva__nadpis">
      <h2 class="nadpis" id="vyzva-h">Máte prostor, který potřebuje nový život?</h2>
      <p class="text mt-1 muted">Napište nám nebo zavolejte. Nezávazně probereme vaše plány a navrhneme první konkrétní kroky.</p>
    </div>

    <div class="vyzva__btn">
      <button class="btn" type="button" data-contact-toggle="inquiry">Poptat projekt &rarr;</button>
    </div>
  </div>
</section>

