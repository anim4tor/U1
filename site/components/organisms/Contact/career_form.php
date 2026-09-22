<div class="flex gap__1 inner-x__1 inner-y__1 ">
	<div class="grid gap__1 place__center-start">
		<h3 class="wrap">Nenašli jste vhodnou pozici? <span class="color__acc">Pošlete nám své CV.</span></h3>
	</div>
</div>
<form id="career-form" action="<?= url('contact.json') ?>" method="POST" data-form="contact" class="grid__2 gap__05 inner-x__1 inner__1 border__top">
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Pozice</label>
		<select name="division" data-contact-input>
			<?php foreach (collection('Jobs') as $job) : ?>
				<option <?= ($job->id() === $page->id()) ? 'selected' : null ?> value="<?= $job->title() . ' - ' . $job->location() ?>"><?= $job->title() . ' - ' . $job->location() ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Jméno a příjmení *</label>
		<input type="text" name="name" required placeholder="Vaše jméno" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Současná firma / škola</label>
		<input type="text" name="company" placeholder="Firma nebo škola" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">E-mail *</label>
		<input type="email" name="email" required placeholder="jmeno@domena.cz" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Telefon</label>
		<input type="text" name="phone" placeholder="+420 ..." data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Životopis / LinkedIn</label>
		<input placeholder="Odkaz na CV (LinkedIn profil, portfolio apod.)" name="cv_link" id="cv_link" type="text" maxlength="255" data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Zpráva *</label>
		<textarea name="message" required placeholder="Napište nám o sobě..." data-contact-input></textarea>
	</div>

	<div class="span__2" data-form-feedback>
		<div data-form-error class="color__acc"></div>
	</div>

	<div class="span__2 gap__1 grid__2">
		<div class="flex justify__start">
			<?= snippet('atoms/Button', [ 'label' => 'Odeslat', 'icon' => false, 'theme' => 'invert', 'node' => 'type="submit" data-form-submit' ]) ?>
		</div>
		<p class="lower font__size__small op__4">Odesláním formuláře souhlasíte se zpracováním osobních údajů dle <a class="link" href="<?= page('privacy')->url() ?>">zásad ochrany osobních údajů.</a></p>
	</div>

</form>