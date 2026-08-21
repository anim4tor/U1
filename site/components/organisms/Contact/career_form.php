<div class="flex gap-1 px-1 py-1">
	<div class="grid gap-1 items-center justify-start">
		<h3 class="text-s flex-wrap">You didn't find a suitable position? <span class="text-acc">Send us your CV.</span></h3>
	</div>
</div>
<form class="grid grid-cols-1 md:grid-cols-2 gap-05 px-1 p-1 border-t">
	<div class="col-span-1 md:col-span-2 grid gap-01">
		<label class="opacity-4 text-xs">Position</label>
		<select name="division" data-contact-input>
			<?php foreach (collection('Jobs') as $job) : ?>
				<option <?= $job === $page ? 'selected' : null ?> value="<?= $job->title() . ' - ' . $job->location() ?>"><?= $job->title() . ' - ' . $job->location() ?></option>
			<?php endforeach ?>
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
		<label class="opacity-4 text-xs">CV</label>
		<input placeholder="Link your CV (LinkedIn profile, personal website, etc.)" name="cv_link" id="cv_link" type="text" maxlength="255">
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

                    