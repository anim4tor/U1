<div class="flex gap__1 inner-x__1 inner-y__1 ">
	<div class="grid gap__1 place__center-start">
		<h3 class="text-s wrap ">Fill out the following form and we will be happy to <span class="color__acc">get back to you.</span></h3>
	</div>
</div>
<form class="grid__2 gap__05 inner-x__1 inner__1 border__top">
	<div class="span__2 grid gap__01">
		<label class="op__4 text-xs">Division</label>
		<select name="division" data-contact-input>
			<option>Office manager</option>
			<option>Marketing & Media</option>
			<option>Sales</option>
			<option>Design</option>
			<option>Accountant</option>	
		</select>
	</div>
	<div class="grid gap__01">
		<label class="op__4 text-xs">Name</label>
		<input type="text" name="name" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 text-xs">Company</label>
		<input type="text" name="company" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 text-xs">Email</label>
		<input type="text" name="email" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 text-xs">Phone</label>
		<input type="text" name="phone" data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 text-xs">Message</label>
		<textarea name="message" data-contact-input></textarea>
	</div>

	<div class="span__2 gap__2 grid__2">
		<?= snippet('atoms/Button', [ 'label' => 'Send', 'icon' => false, 'theme' => 'invert' ]) ?>
		<p class="lower text-s op__4">By sending, you automatically agree to the data processing and the terms <a class="link" href="<?= page('privacy')->url() ?>">principles of personal protection data.</a></p>
	</div>

</form>
