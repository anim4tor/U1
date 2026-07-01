<div class="flex gap__1 inner-x__1 inner-y__1 ">
	<div class="grid gap__1 place__center-start">
		<h3 class="font__size__4  wrap ">You didn't find a suitable position? <span class="color__acc">Send us your CV.</span></h3>
	</div>
</div>
<form class="grid__2 gap__05 inner-x__1 inner__1 border__top">
	<div class="span__2 grid gap__01">
		<label class="op__4 xs">Position</label>
		<select name="division" data-contact-input>
			<?php foreach (collection('Jobs') as $job) : ?>
				<option <?= $job === $page ? 'selected' : null ?> value="<?= $job->title() . ' - ' . $job->location() ?>"><?= $job->title() . ' - ' . $job->location() ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="grid gap__01">
		<label class="op__4 xs">Name</label>
		<input type="text" name="name" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 xs">Company</label>
		<input type="text" name="company" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 xs">Email</label>
		<input type="text" name="email" data-contact-input>
	</div>
	<div class="grid gap__01">
		<label class="op__4 xs">Phone</label>
		<input type="text" name="phone" data-contact-input>
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 xs">CV</label>
		<input placeholder="Link your CV (LinkedIn profile, personal website, etc.)" name="cv_link" id="cv_link" type="text" maxlength="255">
	</div>
	<div class="span__2 grid gap__01">
		<label class="op__4 xs">Message</label>
		<textarea name="message" data-contact-input></textarea>
	</div>
	<div class="span__2 gap__2 grid__2">
		<?= snippet('atoms/Button', [ 'label' => 'Send', 'icon' => false, 'theme' => 'invert' ]) ?>
		<p class="lower s op__4">By sending, you automatically agree to the data processing and the terms <a class="link" href="<?= page('privacy')->url() ?>">principles of personal protection data.</a></p>
	</div>

</form>

                    