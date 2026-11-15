<?php
/**
 * Sekce: Pro koho pracujeme (Carousel log klientů z v65)
 * Loga jsou na světlém pozadí tmavá a na tmavém pozadí invertovaná.
 */
$heading = $page->clientsHeading()->or('Pro koho pracujeme');

$clients = [
    'direct-pojistovna.svg',
    'plzensky-prazdroj.svg',
    'siemens-healthineers.svg',
    'strv.svg',
    'ibm.svg',
    'kentico.svg',
    'atlas-copco.svg',
    'continental.svg',
    'smurfit-westrock.svg',
    'ctp.svg',
    'hartmann-rico.svg',
    'konica-minolta.svg',
    'miele.svg',
    'grundfos.svg',
    'phonexia.svg',
    'purple-technology.svg',
    'seyfor.svg'
];

$logos = [];
foreach ($clients as $clientFile) {
    $path = 'public/assets/images/clients/' . $clientFile;
    if (file_exists($path)) {
        $logos[] = svg($path);
    }
}
?>

<section class="clients-section recognition radius relative z__2" theme="light" aria-labelledby="clients-heading">
	<div class="flex align__center inner-x__4 gap__3 inner-y__2 mobile:grid__1 mobile:gap__1">
		<div class="no__wrap" data-scroll>
			<span class="label font__size__label op__6" id="clients-heading"><?= esc($heading) ?></span>
		</div>
		<div class="logo-ticker-container">
			<div class="logo-ticker-track">
				<div class="logo-ticker-group flex gap__2 inner-x__2 inner-y__1 align__center">
					<?php foreach ($logos as $logo) : ?>
						<figure class="client-logo flex align__center justify__center">
							<?= $logo ?>
						</figure>
					<?php endforeach ?>
				</div>
				<div class="logo-ticker-group flex gap__2 inner-x__2 inner-y__1 align__center" aria-hidden="true">
					<?php foreach ($logos as $logo) : ?>
						<figure class="client-logo flex align__center justify__center">
							<?= $logo ?>
						</figure>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
