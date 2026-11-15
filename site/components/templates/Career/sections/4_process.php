<?php
/**
 * Sekce: Jak probíhá výběr (v65 kariera.html)
 * 3 kroky výběrového řízení v našem designovém systému
 */
$heading = $page->hiringProcessHeading()->or('Jak probíhá výběr');
$steps = isset($steps) ? $steps : $page->hiringProcess()->toStructure();

if ($steps->isEmpty() && $page->process()->isNotEmpty()) {
    $steps = $page->process()->toStructure();
}

if ($steps->isEmpty()) {
    $steps = [
        ['step' => '01', 'title' => 'Napíšeme si', 'text' => 'Pošlete nám životopis a pár vět o sobě na hr@u1.cz.'],
        ['step' => '02', 'title' => 'Zavoláme si', 'text' => 'Online nebo po telefonu upřesníme vaše zkušenosti a očekávání.'],
        ['step' => '03', 'title' => 'Potkáme se',  'text' => 'Potkáte se s budoucím vedoucím i kolegy a proberete vše důležité.']
    ];
}
?>

<section class="hiring-process-section radius relative z__2" theme="invert" aria-labelledby="hiring-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid gap__3">
		
		<div class="grid__3 place__end-start gap__2 mobile:grid__1" data-scroll>
			<div class="span__2">
				<h2 id="hiring-heading" class="font__size__2" data-reveal-text><?= esc($heading) ?></h2>
			</div>
			<div>
				<p class="font__size__default op__7">Pohovor u nás probíhá vždy osobně.</p>
			</div>
		</div>

		<ol class="grid__3 gap__2 mobile:grid__1" data-scroll>
			<?php foreach ($steps as $item) : ?>
				<?php 
				$stepNum = is_array($item) ? ($item['step'] ?? '') : $item->step()->value();
				$stepTitle = is_array($item) ? ($item['title'] ?? '') : $item->title()->value();
				$stepText = is_array($item) ? ($item['text'] ?? '') : $item->text()->value();
				?>
				<li class="grid place__start-stretch gap__1 border__top inner-t__1">
					<span class="label font__size__small color__acc"><?= esc($stepNum) ?></span>
					<h3 class="font__size__3" data-reveal-text><?= esc($stepTitle) ?></h3>
					<p class="font__size__default op__7" data-reveal-text="lines"><?= esc($stepText) ?></p>
				</li>
			<?php endforeach ?>
		</ol>

	</div>
</section>
