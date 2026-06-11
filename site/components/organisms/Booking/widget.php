<div data-tabs="<?= $init ?>">	
	<div data-pane-container>
		<div data-pane="top" >
			<div class="inner-x__2 inner-y__2">
				<div class="grid gap__1 place__center-start">
					<h3 class="m">Start Your Journey – Select Your Yoga Experience</h3>
					<?= snippet('atoms/Button', ['url' => '', 'label' => 'Booking calendar', 'theme' => 'dark', 'node' => 'data-tab="calendar"']) ?>
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
		<div data-pane="lectures" >
			<div class="inner-x__2 inner-y__2">
				<div class="grid gap__1 place__center-start">
					<h3 class="m">Book Your Lecture Today</h3>
					<?= snippet('atoms/Button', ['url' => '', 'label' => 'Booking calendar', 'theme' => 'dark', 'node' => 'data-tab="calendar"']) ?>
				</div>
			</div>
			<a data-tab="top" class="inner-y__05 inner-x__2 flex justify__start op__5"><div class="button upper -wrap-l__04">Back</div></a>
			<nav class="grid place__start-stretch inner-b__1 font__size__4 m">
				<?php foreach (collection('Lectures') as $lecture) : ?>
					<?= snippet('molecules/Lecture/booking', compact('lecture')) ?>
				<?php endforeach ?>
			</nav>
		</div>
		<div data-pane="team" >
			<div class="inner-x__2 inner-y__2">
				<div class="grid gap__1 place__center-start">
					<h3 class="m">Book Your Intructor Today</h3>
					<?= snippet('atoms/Button', ['url' => '', 'label' => 'Booking calendar', 'theme' => 'dark', 'node' => 'data-tab="calendar"']) ?>
				</div>
			</div>
			<a data-tab="top" class="inner-y__05 inner-x__2 flex justify__start op__5"><div class="button upper -wrap-l__04">Back</div></a>
			<nav class="grid place__start-stretch inner-b__1 font__size__4 m">
				<?php foreach (collection('Team') as $instructor) : ?>
					<?= snippet('molecules/Instructor/booking', compact('instructor')) ?>
				<?php endforeach ?>
			</nav>
		</div>
		<div data-pane="workshops" >
			<div class="inner-x__2 inner-y__2">
				<div class="grid gap__1 place__center-start">
					<h3 class="m">Book Your Workshop Today</h3>
					<?= snippet('atoms/Button', ['url' => '', 'label' => 'Booking calendar', 'theme' => 'dark', 'node' => 'data-tab="calendar"']) ?>
				</div>
			</div>
			<a data-tab="top" class="inner-y__05 inner-x__2 flex justify__start op__5"><div class="button upper -wrap-l__04">Back</div></a>
			<nav class="grid place__start-stretch inner-b__1">
				<?php foreach (collection('Workshops') as $event) : ?>
					<?= null//snippet('molecules/Event/booking', compact('event')) ?>
				<?php endforeach ?>
			</nav>
		</div>
		<div data-pane="events" >
			<div class="inner-x__2 inner-y__2">
				<div class="grid gap__1 place__center-start">
					<h3 class="m">Book Your Event Today</h3>
					<?= snippet('atoms/Button', ['url' => '', 'label' => 'Booking calendar', 'theme' => 'dark', 'node' => 'data-tab="calendar"']) ?>
				</div>
			</div>
			<a data-tab="top" class="inner-y__05 inner-x__2 flex justify__start op__5"><div class="button upper -wrap-l__04">Back</div></a>
			<nav class="grid place__start-stretch inner-b__1">
				<?php foreach (collection('Events') as $event) : ?>
					<?= snippet('molecules/Event/booking', compact('event')) ?>
				<?php endforeach ?>
			</nav>
		</div>
		<div data-pane="detail">
			<div data-load>
				
			</div>
		</div>
		<div data-pane="calendar" class="wider">
			<a data-tab="top" class="inner-y__05 inner-x__2 wrap-t__1 flex justify__start op__5"><div class="button upper -wrap-l__04 ">Back</div></a>
			<?php
				$calendar = [];
				$dates = [];
				for ($i = 0; $i < 3; $i++) {
				    $dates[] = (new DateTime())->modify("+{$i} months");
				}
				foreach ($dates as $date) {
				    $calendar[] = $page->generateMonthArray($date);
				}
				// var_dump($calendar);
			?>
			<calendar class="grid gap__1 inner-b__1">
				<?php foreach ($calendar as $month) : ?>
					<month class="grid inner-y__1 inner-x__2 gap__1 border__top">
						<h3 class=""><?= $month['name'] ?></h3>
						<div class="grip">
							<?php foreach ($month['weeks'] as $week) : ?>

								<week class="grid__7">
									<?php foreach ($week['days'] as $day) : ?>
										<?php
											$test = ['date' => $day['date']];
										?>
										<day <?= $day['current'] ? 'current' : null ?> class="grid gap__05 inner__05 inner-b__2 place__space-between-stretch" data-day=<?= $day['date'] ?> style="grid-column-start: <?= $day['index'] ?>">
											<h2 class="s daynum text__left<?= !$day['current'] ? 'op__3' : null ?>"><?= $day['num'] ?></h2>
											<div class="events grid gap__01">
												<?php $event = collection('Lectures')->random()->first(); ?>
												<div class="event flex align__center gap__02"><div class="dot large" style="color: <?= array_rand(option('colors')) ?>"></div><p class="font__size__small upper"><?= $event->title() ?></p></div>
											</div>
										</day>
									<?php endforeach ?>
								</week>
							<?php endforeach ?>
						</div>
					</month>
				<?php endforeach ?>
			</calendar>
		</div>
	</div>
</div>
