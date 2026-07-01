<div class="flex gap__1 inner-x__1 w__12 inner-y__1 ">
	<div class="grid gap__1 place__center-start">
		<h3 class="font__size__4  wrap ">You didn't find a suitable position? <span class="color__acc">Send us your CV.</span></h3>
	</div>
</div>
<form class="grid gap__05 inner-x__1 inner__1 border__top">
	<div class="grid gap__01">
		<label class="op__4 xs">Division</label>
		<select name="division" data-contact-input>
			<option>Office manager</option>
			<option>Marketing & Media</option>
			<option>Sales</option>
			<option>Design</option>
			<option>Accountant</option>	
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
	<div class="grid gap__01">
		<label class="op__4 xs">Message</label>
		<textarea name="message" data-contact-input></textarea>
	</div>

	<?= snippet('atoms/Button', [ 'label' => 'Send', 'icon' => false, 'theme' => 'invert' ]) ?>

</form>

                    