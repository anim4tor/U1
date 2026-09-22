<div class="flex gap__1 inner-x__1 inner-y__1 ">
	<div class="grid gap__1 place__center-start">
		<h3 class="wrap">Vyplňte následující formulář a my se vám rádi <span class="color__acc">ozveme zpět.</span></h3>
	</div>
</div>
<form id="contact-form" action="<?= url('contact.json') ?>" method="POST" data-form="contact" class="grid__2 gap__05 inner-x__1 inner__1 border__top">
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Oddělení</label>
		<select name="division" data-contact-input>
			<option value="Office management">Office management</option>
			<option value="Marketing a média">Marketing a média</option>
			<option value="Obchodní oddělení">Obchodní oddělení</option>
			<option value="Design & Architektura">Design & Architektura</option>
			<option value="Účtárna">Účtárna</option>	
		</select>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Jméno *</label>
		<input type="text" name="name" required placeholder="Vaše jméno" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Společnost</label>
		<input type="text" name="company" placeholder="Název společnosti" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">E-mail *</label>
		<input type="email" name="email" required placeholder="jmeno@firma.cz" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 font__size__small">Telefon</label>
		<input type="text" name="phone" placeholder="+420 ..." data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 font__size__small">Zpráva *</label>
		<textarea name="message" required placeholder="S čím vám můžeme pomoci?" data-contact-input></textarea>
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
 