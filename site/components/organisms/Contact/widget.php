<div data-tabs="office" class="relative" data-fluid>	
	<div class="flex gap__1 inner-x__1 w__12 inner-y__1 inner-b__05 inner-r__2">
		<div class="grid gap__1 place__center-start">
			<h3 class="font__size__4  wrap "><span class="color__acc">Get in touch</span> with us directly or leave us your contact details.</h3>
		</div>
		
	</div>
	
	<div class="flex gap__03 justify__space-between inner-x__1 inner-y__05 border__bottom">
		<div data-tab="office" class="upper xs">Office</div>
		<div data-tab="marketing" class="upper xs">Marketing</div>
		<div data-tab="sales" class="upper xs">Sales</div>
		<div data-tab="design" class="upper xs">Design</div>
		<div data-tab="accounts" class="upper xs">Accounts</div>
		<!-- <div data-tab="form" class="upper s">Form</div> -->
	</div>
	<div data-pane-container class="grid__stack place__start-stretch">
		<div data-pane="office" class="relative">
			<div class="absolute inset__stretch no__overflow "><?= snippet('atoms/Image', ['url' => 'contact_office.jpg', 'css' => '']) ?></div>
			<div class="grid h__15">
				<div class="relative grid gap__05 place__end-start inner-x__1 inner-y__1 ">
					<div class="grid gap__05">
						<p class="lower l">Office manager</p>
						<div class="flex gap__02">
							<?= snippet('atoms/Button', [ 'url' => 'mailto: svacinova@u1.cz', 'label' => 'svacinova@u1.cz', 'icon' => false, 'theme' => false, 'css' => 'bg__light/20 color__invert/60']) ?>
							<?= snippet('atoms/Button', [ 'url' => 'tel:+402 601 088 517', 'label' => '+402 601 088 517', 'icon' => false, 'theme' => false, 'css' => 'bg__light/20 color__invert/60']) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div data-pane="form" >
			<div class="inner-x__1 inner-y__1">
				<div class="grid gap__1 place__center-start">
					<h3 class="xs">Fill out the following form and we will be happy to get back to you</h3>
				</div>
			</div>
			<nav class="grid place__end-stretch inner-b__1 font__size__4 m">
				<a data-tab="lectures" class="link flex align__center gap__03 inner-x__2 border__top inner-y__1" aria-label="Lectures">
					<span class="">Lectures</span>
					<span class="icon --add wrap-t__02"><?= svg('public/assets/images/ui/ui_plus.svg') ?></span>
				</a>
				<a data-tab="team" class="link flex align__center gap__03 inner-x__2 border__top inner-y__1" aria-label="Instructors">
					<span class="">Instructors</span>
					<span class="icon --add wrap-t__02"><?= svg('public/assets/images/ui/ui_plus.svg') ?></span>
				</a>
				<a data-tab="workshops" class="link flex align__center gap__03 inner-x__2 border__top inner-y__1" aria-label="Workshops">
					<span class="">Workshops</span>
					<span class="icon --add wrap-t__02"><?= svg('public/assets/images/ui/ui_plus.svg') ?></span>
				</a>
				<a data-tab="events" class="link flex align__center gap__03 inner-x__2 border__top inner-y__1" aria-label="Events">
					<span class="">Events</span>
					<span class="icon --add wrap-t__02"><?= svg('public/assets/images/ui/ui_plus.svg') ?></span>
				</a>
			</nav>
		</div>
		
	</div>
	<div class="absolute top__05 right__05 z__1">
		<?= snippet('atoms/Button', [ 'url' => '', 'label' => false, 'icon' => 'close', 'theme' => false, 'css' => 'circle --small bg__light/20 color__invert/80', 'node' => 'data-contact-close']) ?>
	</div>
</div>
