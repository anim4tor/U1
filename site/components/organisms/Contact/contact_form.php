<div class="flex gap-1 px-1 py-1">
	<div class="grid gap-1 items-center justify-start">
		<h3 class="text-s flex-wrap">Fill out the following form and we will be happy to <span class="text-acc">get back to you.</span></h3>
	</div>
</div>
<form class="grid grid-cols-1 md:grid-cols-2 gap-05 px-1 p-1 border-t">
	<div class="col-span-1 md:col-span-2 grid gap-01">
		<label class="opacity-4 text-xs">Division</label>
		<select name="division" data-contact-input>
			<option>Office manager</option>
			<option>Marketing & Media</option>
			<option>Sales</option>
			<option>Design</option>
			<option>Accountant</option>	
		</select>
	</div>
	<div class="grid gap-01">
		<label class="opacity-4 text-xs">Name</label>
		<input type="text" name="name" data-contact-input>
	</div>
	<div class="grid gap-01">
		<label class="opacity-4 text-xs">Company</label>
		<input type="text" name="company" data-contact-input>
	</div>
	<div class="grid gap-01">
		<label class="opacity-4 text-xs">Email</label>
		<input type="text" name="email" data-contact-input>
	</div>
	<div class="grid gap-01">
		<label class="opacity-4 text-xs">Phone</label>
		<input type="text" name="phone" data-contact-input>
	</div>
	<div class="col-span-1 md:col-span-2 grid gap-01">
		<label class="opacity-4 text-xs">Message</label>
		<textarea name="message" data-contact-input></textarea>
	</div>

	<div class="col-span-1 md:col-span-2 gap-2 grid grid-cols-1 md:grid-cols-2">
		<?= snippet('atoms/Button', [ 'label' => 'Send', 'icon' => false, 'theme' => 'invert' ]) ?>
		<p class="lowercase text-s opacity-4">By sending, you automatically agree to the data processing and the terms <a class="link" href="<?= page('privacy')->url() ?>">principles of personal protection data.</a></p>
	</div>

</form>
