<?php
$divisions = [
	[
		'name'        => 'Office manager',
		'email'       => 'svacinova@u1.cz',
		'phone'       => '+420 601 088 517',
		'phone_clean' => '+420601088517',
		'image'       => 'contact_office.jpg',
	],
	[
		'name'        => 'Marketing a média',
		'email'       => 'marketing@u1.cz',
		'phone'       => '+420 725 020 888',
		'phone_clean' => '+420725020888',
		'image'       => 'contact_marketing.jpg',
	],
	[
		'name'        => 'Obchod & Projekty',
		'email'       => 'sales@u1.cz',
		'phone'       => '+420 737 758 528',
		'phone_clean' => '+420737758528',
		'image'       => 'contact_sales.jpg',
	],
	[
		'name'        => 'Design & Architektura',
		'email'       => 'design@u1.cz',
		'phone'       => '+420 737 758 528',
		'phone_clean' => '+420737758528',
		'image'       => 'contact_design.jpg',
	],
	[
		'name'        => 'Finance & Účetní',
		'email'       => 'accountant@u1.cz',
		'phone'       => '+420 720 834 765',
		'phone_clean' => '+420720834765',
		'image'       => 'contact_accounts.jpg',
	],
	[
		'name'        => 'Kariéra & HR',
		'email'       => 'kariera@u1.cz',
		'phone'       => '+420 601 088 517',
		'phone_clean' => '+420601088517',
		'image'       => 'contact_hr.jpg',
	],
];
?>

<section id="oddeleni" class="contact-divisions radius" theme="dark">
	<div class="grid gap__2 inner__4">
		<!-- <div class="flex justify__space-between align__center" data-scroll>
			<div class="flex align__start gap__01">
				<div class="w__03 h__03 bg__acc"></div>
				<h2 data-reveal-text>Oddělení</h2>
			</div>
		</div> -->

		<div class="grid__3 mobile:grid__1 gap__2">
			<?php foreach ($divisions as $div) : ?>
				<article class="card relative radius overflow__hidden flex place__space-between-stretch gap__1 inner__1" data-scroll style="background: rgba(var(--color-invert), 0.03); flex-direction: column;">
					<div class="grid gap__1">
						<div class="item__figure img__radius overflow__hidden" data-scroll style="max-width: 140px;">
							<?= snippet('atoms/Image', [
								'url'     => $div['image'],
								'css'     => 'w__100 aspect__3/4 grid object__cover',
								'reveal'  => true
							]) ?>
						</div>
						<div class="grid gap__02">
							<h3 class="font__size__3"><?= $div['name'] ?></h3>
						</div>
					</div>

					<div class="flex wrap gap__05 ">
						<?php if (!empty($div['email'])) : ?>
							<a href="mailto:<?= $div['email'] ?>" class="button" theme="invert-ghost" hover="invert">
								<label class="upper font__size__small"><span><?= $div['email'] ?></span></label>
							</a>
						<?php endif ?>

						<?php if (!empty($div['phone'])) : ?>
							<a href="tel:<?= $div['phone_clean'] ?>" class="button" theme="invert-ghost" hover="invert">
								<label class="upper font__size__small"><span><?= $div['phone'] ?></span></label>
							</a>
						<?php endif ?>
					</div>
				</article>
			<?php endforeach ?>
		</div>
	</div>
</section>
