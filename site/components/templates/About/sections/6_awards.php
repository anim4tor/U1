<?php
/**
 * Sekce: Ocenění a nominace (v65 o-nas.html)
 * Časová osa / přehled ocenění v našem designovém systému
 */
$heading = $page->awardsHeading()->or('Ocenění a nominace');
$awards = $page->awards()->toStructure();

if ($awards->isEmpty()) {
    $awards = [
        ['year' => '2025', 'title' => 'Kanceláře roku', 'detail' => 'vítěz, Direct pojišťovna'],
        ['year' => '2023', 'title' => 'Grand Prix architektů', 'detail' => 'nominace'],
        ['year' => '2022', 'title' => 'Interiér roku', 'detail' => 'nominace'],
        ['year' => '2021', 'title' => 'Interiér roku, Kanceláře roku', 'detail' => 'nominace'],
        ['year' => '2018', 'title' => 'Designblok', 'detail' => 'Nejlepší novinka výrobce, ONLY2']
    ];
}
?>

<section class="awards-section radius relative z__2" theme="invert" aria-labelledby="awards-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid__4 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="awards-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
			</div>
		</div>

		<ol class="grid gap__0 border__bottom" data-scroll>
			<?php foreach ($awards as $item) : ?>
				<?php 
				$yr = is_array($item) ? ($item['year'] ?? '') : $item->year()->value();
				$tit = is_array($item) ? ($item['title'] ?? '') : $item->title()->value();
				$det = is_array($item) ? ($item['detail'] ?? '') : $item->detail()->value();
				?>
				<li class="border__top">
					<div class="grid__4 gap__2 align__baseline inner-y__1 mobile:grid__1 mobile:gap__05">
						<span class="span__1 font__size__small op__5 font__weight__500 mobile:span__1"><?= esc($yr) ?></span>
						<h3 class="span__2 font__size__3 mobile:span__1"><?= esc($tit) ?></h3>
						<p class="span__1 font__size__default op__7 text__right mobile:text__left mobile:span__1"><?= esc($det) ?></p>
					</div>
				</li>
			<?php endforeach ?>
		</ol>

	</div>
</section>
