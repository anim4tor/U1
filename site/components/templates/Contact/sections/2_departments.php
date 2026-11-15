<?php
/**
 * Sekce: Kontakty na oddělení (v65 kontakt.html)
 * 6 karet oddělení ve 3 sloupcích v našem designovém systému
 */
$heading = $page->departmentsHeading()->or('Kontakty na oddělení');
$subtitle = $page->departmentsSubtitle()->or('Poptávku můžete poslat i přes formulář, otevře ho tlačítko Poptat projekt.');

$departments = [];
if ($page->departments()->isNotEmpty()) {
    foreach ($page->departments()->toStructure() as $dept) {
        $departments[] = [
            'name'  => $dept->name()->value(),
            'email' => $dept->email()->value(),
            'phone' => $dept->phone()->value()
        ];
    }
}

if (empty($departments)) {
    $departments = [
        ['name' => 'Obchod a nové projekty', 'email' => 'sales@u1.cz',      'phone' => ''],
        ['name' => 'Obecné dotazy',          'email' => 'info@u1.cz',       'phone' => ''],
        ['name' => 'Design a architektura',  'email' => 'design@u1.cz',     'phone' => '+420 737 758 528'],
        ['name' => 'Marketing a média',      'email' => 'marketing@u1.cz',  'phone' => '+420 725 020 888'],
        ['name' => 'Kariéra a HR',           'email' => 'hr@u1.cz',         'phone' => ''],
        ['name' => 'Účtárna',                'email' => 'accountant@u1.cz', 'phone' => '+420 720 834 765']
    ];
}
?>

<section class="departments-section radius relative z__2" theme="invert" aria-labelledby="dept-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="dept-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
			</div>
			<div class="flex align__end">
				<p class="font__size__default op__7">
					<?= esc($subtitle) ?>
				</p>
			</div>
		</div>

		<div class="grid__3 gap__2 gap-y__3 mobile:grid__1" data-scroll>
			<?php foreach ($departments as $dept) : ?>
				<div class="border__top inner-t__1 grid place__start-start gap__05">
					<h3 class="font__size__3" data-reveal-text data-split-ignore><?= esc($dept['name']) ?></h3>
					<?php if (!empty($dept['email'])) : ?>
						<a href="mailto:<?= esc($dept['email']) ?>" class="font__size__default hover:color__acc transition:color">
							<?= esc($dept['email']) ?>
						</a>
					<?php endif ?>
					<?php if (!empty($dept['phone'])) : ?>
						<a href="tel:<?= esc(preg_replace('/\s+/', '', $dept['phone'])) ?>" class="font__size__default hover:color__acc transition:color">
							<?= esc($dept['phone']) ?>
						</a>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		</div>

	</div>
</section>
