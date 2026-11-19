<?php
/**
 * Šablona: Detail Služby / Solution (podle v65 sluzba-*.html s použitím design systému U1)
 */
$cover = $page->cover()->toFile() 
    ?? site()->images()->filterBy('name', '*=', 'solution')->first() 
    ?? site()->images()->first();

$category = $page->category()->isNotEmpty() ? $page->category()->value() : 'Služba';
$perex = $page->intro()->isNotEmpty() ? $page->intro()->inline() : ($page->excerpt()->isNotEmpty() ? $page->excerpt()->inline() : null);

// Specifikace
$workModel = $page->workModel()->isNotEmpty() ? $page->workModel()->value() : ($page->content()->has('model') && $page->content()->get('model')->isNotEmpty() ? $page->content()->get('model')->value() : 'Design & Build (jedna smlouva)');
$location = $page->location()->or('Celá ČR a Slovensko');

// Co služba zahrnuje
$includes = $page->includes()->toStructure();

// Související realizace
$relatedProjects = $page->relatedprojects()->toPages();
if ($relatedProjects->isEmpty()) {
    $relatedProjects = site()->index()->filterBy('intendedTemplate', 'project')->filter(function($p) use ($page) {
        return in_array($page->title()->value(), $p->solutions()->split());
    })->limit(3);
}
if ($relatedProjects->isEmpty()) {
    $projectsPage = site()->find('projects');
    $relatedProjects = $projectsPage ? $projectsPage->children()->listed()->limit(3) : pages();
}

// Další služby pro boční panel
$otherSolutions = $page->siblings()->listed()->not($page)->limit(4);

// Časté otázky (FAQ)
$faqs = $page->faq()->toStructure();
if ($faqs->isEmpty()) {
    $faqs = [
        [
            'question' => 'Co znamená kancelář na klíč (Design & Build)?',
            'answer'   => 'Design & Build znamená, že od prvního architektonického konceptu přes stavební úpravy až po dodávku a montáž atypického i typového nábytku jednáte s jedním partnerem. Přebíráme plnou garanci za termín, rozpočet i finální kvalitu provedení.'
        ],
        [
            'question' => 'Jak probíhá cenová nabídka a kontrola rozpočtu?',
            'answer'   => 'Už v úvodní studii pracujeme s reálným nákladovým rámcem. Rozpočet průběžně aktualizujeme podle vybraných materiálů a technologií, takže před zahájením stavby přesně víte, kolik bude realizace stát.'
        ],
        [
            'question' => 'Kde všude projekty realizujete?',
            'answer'   => 'Působíme po celé České republice a na Slovensku. Naše realizační týmy a zázemí máme v Brně, Praze i Bratislavě.'
        ]
    ];
}

// Fotogalerie
$gallery = $page->gallery()->toFiles();

// Fotografie pro příběh / postup zakázky (2–4 fotky)
$storyImages = [];
if ($gallery->isNotEmpty()) {
    foreach ($gallery as $f) {
        $storyImages[] = $f;
    }
}
if (count($storyImages) < 4) {
    $directProject = site()->find('projects/direct-pojistovna');
    if ($directProject && $directProject->images()->isNotEmpty()) {
        foreach ($directProject->images() as $f) {
            $storyImages[] = $f;
            if (count($storyImages) >= 6) break;
        }
    }
}
if (count($storyImages) < 4 && $relatedProjects->isNotEmpty()) {
    foreach ($relatedProjects as $p) {
        foreach ($p->images() as $f) {
            $storyImages[] = $f;
            if (count($storyImages) >= 6) break;
        }
    }
}
if (count($storyImages) < 4) {
    foreach (site()->index()->filterBy('intendedTemplate', 'project') as $p) {
        foreach ($p->images() as $f) {
            $storyImages[] = $f;
            if (count($storyImages) >= 6) break 2;
        }
    }
}
?>

<!-- Hero sekce služby -->
<?= snippet('sections/Hero/index', [
	'bottomRadius'   => false,
	'gradientBottom' => true
]) ?>


<!-- Hlavní sekce: O službě & Parametry (U1 Design System) -->
<section class="about solution-intro radius-t__0" aria-label="O službě">
	<div class="bg absolute inset__stretch radius-b radius-t__0" theme="dark"></div>
	<div data-scroll class="grid__8 place__start-stretch gap__3 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 color__invert relative">
		<!-- Pravý sloupec: Specifikace služby & Další služby -->
		<div class="span__3 sticky top__3 mobile:span__1 solution-specs grid gap__2 align__start" data-scroll>
			
			<div class="grid gap__1">
				
			<div class="grid__2 place__start-start gap__2 border__top inner-y__05 mobile:gap__1">
				<?= snippet('atoms/Label', ['text' => 'Model']) ?>
				<p class="font__size__default"><?= esc($workModel) ?></p>
			</div>

			<div class="grid__2 place__start-start gap__2 border__top inner-y__05 mobile:gap__1">
				<?= snippet('atoms/Label', ['text' => 'Působnost']) ?>
				<p class="font__size__default"><?= esc($location) ?></p>
			</div>

			<?php if ($relatedProjects->first()): ?>
				<div class="grid__2 place__start-start gap__2 border__top inner-y__05 mobile:gap__1">
					<?= snippet('atoms/Label', ['text' => 'Příklad z praxe']) ?>
					<p class="font__size__default">
						<a href="<?= $relatedProjects->first()->url() ?>" class="link font__weight__600">
							<?= esc($relatedProjects->first()->title()) ?>
						</a>
					</p>
				</div>
			<?php endif ?>

			</div>

			<div class="inner-t__1">
				<?= snippet('atoms/Button', [
					'label' => 'Poptat službu',
					'icon'  => 'arrow-right',
					'theme' => 'acc',
					'hover' => 'dark',
					'node'  => 'data-contact-toggle="inquiry"'
				]) ?>
			</div>

			<!-- Další služby -->
			<?php if ($otherSolutions->isNotEmpty()): ?>
				<div class="grid gap__1 inner-t__2">
					<?= snippet('atoms/Label', ['text' => 'Další služby']) ?>
					<div class="grid gap__0">
						<?php foreach ($otherSolutions as $sol): ?>
							<a href="<?= $sol->url() ?>" class="flex justify__space-between align__center inner-y__05 border__bottom link">
								<span class="font__size__default"><?= esc($sol->title()) ?></span>
								<span class="color__acc font__size__small">→</span>
							</a>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
		</div>
		<div></div>
		<!-- Hlavní sloupec: Popis, rozsah a příběh zakázky (roztažený sloupec span__5) -->
		<div class="span__4 mobile:span__1 flex flex__dir__col gap__3">
			<div class="grid gap__3">
				
				<div class="grid gap__1 place__start-start">
					<?php if ($perex): ?>
						<div data-reveal-text="lines" class="font__size__3 font__weight__500">
							<?= $perex ?>
						</div>
					<?php endif ?>
					<?php if ($page->details()->isNotEmpty()): ?>
						<div class="font__size__default op__8 leading__relaxed grid gap__1">
							<?= $page->details() ?>
						</div>
					<?php endif ?>
				</div>


				<!-- Co služba zahrnuje -->
				<?php if ($includes->isNotEmpty()): ?>
					<div class="solution-includes grid gap__1">
						<h3 class="larger"><?= esc($page->includesHeadline()->or('Co služba zahrnuje')) ?></h3>
						<ul class="grid gap__1 list-unstyled">
							<?php foreach ($includes as $item): ?>
								<li class="flex gap__1 align__start relative">
									<span class="color__acc font__size__small shrink__0">✓</span>
									<div>
										<?php if ($item->title()->isNotEmpty()): ?>
											<strong class="font__weight__600"><?= esc($item->title()) ?></strong><?php if ($item->text()->isNotEmpty()): ?>: <?php endif ?>
										<?php endif ?>
										<?php if ($item->text()->isNotEmpty()): ?>
											<span class="op__8"><?= esc($item->text()) ?></span>
										<?php endif ?>
									</div>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php else: ?>
					<div class="solution-includes grid gap__1">
						<h3 class="larger"><?= esc($page->includesHeadline()->or('Co služba zahrnuje')) ?></h3>
						<ul class="grid gap__1 list-unstyled">
							<li class="flex gap__1 align__start relative">
								<span class="color__acc font__size__small shrink__0">✓</span>
								<span>Architektonická studie a dispoziční řešení prostoru (space planning)</span>
							</li>
							<li class="flex gap__1 align__start relative">
								<span class="color__acc font__size__small shrink__0">✓</span>
								<span>Příprava rozpočtu, harmonogramu a technické koordinace</span>
							</li>
							<li class="flex gap__1 align__start relative">
								<span class="color__acc font__size__small shrink__0">✓</span>
								<span>Stavební úpravy, SDK příčky, skleněné stěny, podlahy a elektroinstalace</span>
							</li>
							<li class="flex gap__1 align__start relative">
								<span class="color__acc font__size__small shrink__0">✓</span>
								<span>Výroba autorského i atypického nábytku z vlastního závodu U1</span>
							</li>
							<li class="flex gap__1 align__start relative">
								<span class="color__acc font__size__small shrink__0">✓</span>
								<span>Autorský a technický dozor po celou dobu realizace až po předání</span>
							</li>
						</ul>
					</div>
				<?php endif ?>

				<!-- Příběh / postup zakázky: Od první schůzky po realizaci fit-outu -->
				<div class="solution-story grid gap__3 " data-scroll>
					<div class="grid gap__1 place__start-start">
						<h3 class="larger">Příběh zakázky: Od první vize po realizaci fit-outu</h2>
						<p class="font__size__default op__8 leading__relaxed">
							Kompletní realizace interiéru v modelu Design &amp; Build není sledem náhodných kroků, ale promyšleným partnerským procesem. Od první konzultace až po předání klíčů držíme celou vizi, rozpočet i realizaci pod jednou střechou.
						</p>
					</div>

					<!-- Fáze 01: Úvodní setkání a definice zadání -->
					<article class="solution-step grid gap__1" data-scroll>
						<div class="flex gap__1 align__baseline">
							<h3 class="">Úvodní setkání &amp; space audit</h3>
						</div>
						<div class="grid gap__1 op__8 font__size__default leading__relaxed">
							<p>
								Každý projekt začíná nasloucháním. Během úvodního workshopu podrobně zjišťujeme, jak vaše firma doopravdy funguje, jaké máte firemní rituály, kolik času lidé tráví v týmech a kolik na soustředěnou práci. Zkoumáme nejen technické parametry budovy, ale i dynamiku plánovaného růstu firmy v horizontu tří až pěti let.
							</p>
							<p>
								Provedeme důkladný stavebně-technický průzkum prostor a definujeme jasné mantinely: časový harmonogram a rozpočtový strop, který je pro nás od první chvíle závazný. Máte jediného partnera, který ručí za celý výsledek.
							</p>
						</div>
						<?php if (!empty($storyImages[0])): ?>
							<figure class="solution-step__figure grid gap__05 inner-t__05">
								<div class="aspect__16/9 img__radius relative no__overflow" data-reveal-image>
									<?= snippet('atoms/Image', [
										'img'      => $storyImages[0],
										'css'      => 'aspect__16/9 img__radius',
										'parallax' => 1
									]) ?>
								</div>
								<figcaption class="font__size__small op__5">Prostorový audit a materiálové vzorkování v úvodní fázi projektu</figcaption>
							</figure>
						<?php endif ?>
					</article>

					<!-- Fáze 02: Architektonický koncept & Space planning -->
					<article class="solution-step grid gap__1" data-scroll>
						<div class="flex gap__1 align__baseline">
							<h3 class="">Architektonický koncept a 3D vizualizace</h3>
						</div>
						<div class="grid gap__1 op__8 font__size__default leading__relaxed">
							<p>
								Naši architekti přetaví zadání do funkčního dispozičního řešení (space planning). Připravujeme test-fity a varianty uspořádání, které reagují na světelné podmínky, ergonomii i akustickou pohodu. Zónujeme prostor tak, aby tok lidí byl přirozený a nerušil týmy při hluboké práci.
							</p>
							<p>
								Společně ladíme materiály, textury a barevnost ve vzorkovně U1. Vytváříme detailní 3D vizualizace, díky kterým přesně vidíte budoucí atmosféru – od skleněných příček přes akustické podhledy až po osvětlení s proměnlivou chromatičností.
							</p>
						</div>
						<?php if (!empty($storyImages[1])): ?>
							<figure class="solution-step__figure grid gap__05 inner-t__05">
								<div class="aspect__16/9 img__radius relative no__overflow" data-reveal-image>
									<?= snippet('atoms/Image', [
										'img'      => $storyImages[1],
										'css'      => 'aspect__16/9 img__radius',
										'parallax' => 1
									]) ?>
								</div>
								<figcaption class="font__size__small op__5">Dispoziční řešení a návaznost zón pro soustředění i kolaboraci</figcaption>
							</figure>
						<?php endif ?>
					</article>

					<!-- Fáze 03: Vlastní výroba nábytku v dílnách U1 -->
					<article class="solution-step grid gap__1" data-scroll>
						<div class="flex gap__1 align__baseline">
							<h3 class="">Zakázková výroba v dílnách U1</h3>
						</div>
						<div class="grid gap__1 op__8 font__size__default leading__relaxed">
							<p>
								Srdcem naší soběstačnosti je vlastní výrobní závod. Zatímco na stavbě probíhají přípravné práce, naši truhláři a technologové vyrábí atypický nábytek, recepční pulty, vestavné kuchyňky i modulární sezení přesně na milimetr dle autorského návrhu.
							</p>
							<p>
								Vlastní výroba nám dává stoprocentní kontrolu nad kvalitou materiálů, detaily spojů a především nad termíny dodání. Nejsme závislí na zprostředkovatelích a garantujeme prémiové řemeslné zpracování s dlouhou životností.
							</p>
						</div>
						<?php if (!empty($storyImages[2])): ?>
							<figure class="solution-step__figure grid gap__05 inner-t__05">
								<div class="aspect__16/9 img__radius relative no__overflow" data-reveal-image>
									<?= snippet('atoms/Image', [
										'img'      => $storyImages[2],
										'css'      => 'aspect__16/9 img__radius',
										'parallax' => 1
									]) ?>
								</div>
								<figcaption class="font__size__small op__5">Atypická truhlářská výroba a autorské prvky z výrobního závodu U1</figcaption>
							</figure>
						<?php endif ?>
					</article>

					<!-- Fáze 04: Stavební fit-out a předání na klíč -->
					<article class="solution-step grid gap__1" data-scroll>
						<div class="flex gap__1 align__baseline">
							<h3 class="">Stavební fit-out &amp; předání na klíč</h3>
						</div>
						<div class="grid gap__1 op__8 font__size__default leading__relaxed">
							<p>
								Koordinace stavby je disciplína, kde rozhoduje přesnost na dny. Náš projektový manažer řídí všechny profese: stavební úpravy, SDK příčky, skleněné stěny, vzduchotechniku, silnoproudé i slaboproudé rozvody a pokládku podlah. Všechny profese na sebe navazují v přesném taktu bez prostojů.
							</p>
							<p>
								Finální fází je montáž nábytku, zapojení technologií, důkladné akustické doladění a hloubkový úklid. Předáváme vám prostor připravený k okamžitému užívání. Naší garancí a poprodejním servisem spolupráce teprve začíná.
							</p>
						</div>
						<?php if (!empty($storyImages[3])): ?>
							<figure class="solution-step__figure grid gap__05 inner-t__05">
								<div class="aspect__16/9 img__radius relative no__overflow" data-reveal-image>
									<?= snippet('atoms/Image', [
										'img'      => $storyImages[3],
										'css'      => 'aspect__16/9 img__radius',
										'parallax' => 1
									]) ?>
								</div>
								<figcaption class="font__size__small op__5">Finální předání zrealizovaného interiéru připraveného k okamžitému provozu</figcaption>
							</figure>
						<?php endif ?>
					</article>
				</div>
		</div>

		
	</div>
</section>

<!-- Fotogalerie (pokud je vyplněna) -->
<?php if ($gallery->isNotEmpty()) : ?>
<section class="gallery radius" theme="dark" aria-label="Fotogalerie realizací">
	<div class="grid__2 gap__2 inner-x__4 inner-y__4 mobile:grid__1 mobile:inner-x__1 mobile:inner-y__2">
		<?php foreach ($gallery as $image) : ?>
			<?php if ($image->orientation() === "landscape") : ?>
				<div class="grid span__2 inner__0" data-scroll>
					<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__16/9 img__radius']) ?>
				</div>
			<?php else : ?>
				<div class="grid inner__0" data-scroll>
					<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__4/3 img__radius']) ?>
				</div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>
<?php endif; ?>

<!-- Realizace s touto službou -->
<?php if ($relatedProjects->isNotEmpty()): ?>
	<?= snippet('sections/Projects/related', [
		'projects' => $relatedProjects,
		'title'    => 'Realizace s touto službou',
		'theme'    => 'invert'
	]) ?>
<?php endif ?>

<!-- Časté dotazy ke službě -->
<?php if (!empty($faqs)): ?>
<section class="faq radius" theme="dark" data-scroll aria-labelledby="solution-faq-heading">
	<div class="grid__4 gap__2 inner-x__4 inner-y__5 mobile:grid__1 mobile:inner-x__1 mobile:inner-y__3">
		<div class="span__2 grid gap__1 place__start-start">
			<h2 id="solution-faq-heading" class="font__size__2"><?= esc($page->faqHeadline()->or('Časté dotazy ke službě')) ?></h2>
		</div>
		<div class="span__2 grid gap__1">
			<ol class="faq__list grid" data-scroll data-collapsibles="true">
				<?php foreach ($faqs as $item) : ?>
					<?php 
					$itemObj = is_array($item) ? new \Kirby\Cms\StructureObject(['content' => $item]) : $item;
					?>
					<?= snippet('molecules/Collapsible', ['item' => $itemObj, 'list' => $faqs]) ?>
				<?php endforeach ?>
				<div class="border__top"></div>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>

<!-- Články k tématu -->
<?= snippet('sections/Feed/related') ?>

<!-- Výzva / CTA -->
<?= snippet('sections/Cta') ?>
