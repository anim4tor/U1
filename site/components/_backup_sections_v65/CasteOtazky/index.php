<?php
/**
 * Sekce: Časté otázky (FAQ akordeon)
 * Vzor: v65 index.html (data-blok="caste-otazky")
 */

$heading = $page->faqheading()->isNotEmpty() ? $page->faqheading()->html() : 'Časté otázky';
$faqs = $page->faq()->toStructure();

$defaultFaqs = [
    [
        'q' => 'Co znamená kancelář na klíč?',
        'a' => 'Navrhneme, postavíme a vybavíme kanceláře na základě jedné smlouvy. Za návrh, stavbu, projektové řízení i nábytek odpovídáme my, takže nemusíte koordinovat několik dodavatelů.'
    ],
    [
        'q' => 'Postavíte kanceláře i podle návrhu jiného architekta?',
        'a' => 'Ano. Kanceláře postavíme i podle projektu externího architekta, takto jsme realizovali kanceláře v CTParku Borská pole v Plzni. Autorství návrhu zůstává jeho tvůrci.'
    ],
    [
        'q' => 'Kde kanceláře stavíte?',
        'a' => 'Sídlo a showroom máme v Brně, zastoupení v Praze. Kanceláře navrhujeme a stavíme po celé České republice i na Slovensku.'
    ],
    [
        'q' => 'Jak dlouho trvá fit-out kanceláří?',
        'a' => 'Záleží na rozsahu a výchozím stavu prostoru. Kanceláře v CTParku Borská pole jsme od holého betonu realizovali za pět měsíců. Přesný harmonogram vám představíme po úvodní prohlídce prostor.'
    ],
    [
        'q' => 'Kdo nábytek na míru vyrábí?',
        'a' => 'Ověření truhláři, se kterými dlouhodobě spolupracujeme. Návrh, technické detaily, koordinaci a montáž řídíme my, za výsledek odpovídáme jako jeden partner. Vlastní nábytková řada U1 Only2 získala na Designbloku cenu Nejlepší novinka.'
    ]
];
?>
<section class="sek bila" aria-labelledby="faq-h" data-blok="caste-otazky">
  <div class="g">
    <h2 class="faq__hlava nadpis" id="faq-h"><?= $heading ?></h2>
    
    <div class="faq">
      <?php if ($faqs->isNotEmpty()) : ?>
        <?php foreach ($faqs as $item) : ?>
          <details>
            <summary class="text"><?= $item->question()->html() ?></summary>
            <p><?= $item->answer()->html() ?></p>
          </details>
        <?php endforeach ?>
      <?php else : ?>
        <?php foreach ($defaultFaqs as $item) : ?>
          <details>
            <summary class="text"><?= $item['q'] ?></summary>
            <p><?= $item['a'] ?></p>
          </details>
        <?php endforeach ?>
      <?php endif ?>
    </div>
  </div>
</section>

