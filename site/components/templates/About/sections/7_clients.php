<?php
/**
 * Sekce: Pro koho pracujeme (Carousel log klientů z v65)
 * Na front-endu se zobrazují pouze loga.
 */
$heading = $page->clientsHeading()->or('Pro koho pracujeme');

$logos = [];
$clientsStructure = $page->clients()->toStructure();

if ($clientsStructure->isNotEmpty()) {
    foreach ($clientsStructure as $client) {
        $logoFile = $client->logo()->toFile() ?? $page->file($client->logo()->value());
        $rendered = null;

        if ($logoFile) {
            if ($logoFile->extension() === 'svg') {
                $rendered = svg($logoFile);
            } else {
                $rendered = '<img src="' . esc($logoFile->url()) . '" alt="' . esc($client->name()) . '" class="client-logo-img" />';
            }
        } else {
            // Fallback by slug/file in assets or content
            $slug = \Kirby\Toolkit\Str::slug($client->name());
            $candidatePath = 'public/assets/images/clients/' . $slug . '.svg';
            if (file_exists($candidatePath)) {
                $rendered = svg($candidatePath);
            } else {
                $rawLogo = $client->logo()->value();
                if ($rawLogo && file_exists('public/content/4_about/' . $rawLogo)) {
                    $rendered = svg('public/content/4_about/' . $rawLogo);
                }
            }
        }

        if ($rendered) {
            $logos[] = [
                'html' => $rendered,
                'name' => $client->name()->value()
            ];
        }
    }
}

// Fallback if no structure items or logos found
if (empty($logos)) {
    $fallbackClients = [
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
    foreach ($fallbackClients as $clientFile) {
        $path = 'public/assets/images/clients/' . $clientFile;
        if (file_exists($path)) {
            $logos[] = [
                'html' => svg($path),
                'name' => pathinfo($clientFile, PATHINFO_FILENAME)
            ];
        }
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
						<figure class="client-logo flex align__center justify__center" title="<?= esc($logo['name']) ?>">
							<?= $logo['html'] ?>
						</figure>
					<?php endforeach ?>
				</div>
				<div class="logo-ticker-group flex gap__2 inner-x__2 inner-y__1 align__center" aria-hidden="true">
					<?php foreach ($logos as $logo) : ?>
						<figure class="client-logo flex align__center justify__center" title="<?= esc($logo['name']) ?>">
							<?= $logo['html'] ?>
						</figure>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
