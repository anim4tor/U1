<?php
$templateName    = $page->intendedTemplate()->name();
$isCareerLanding = ($templateName === 'career');
$isJobsContext   = in_array($templateName, ['positions', 'job'], true);
$jobsCount       = collection('Jobs')->count();
$positionsPage   = page('career/positions') ?? page('career')->find('positions');
$positionsUrl    = $positionsPage ? $positionsPage->url() : url('career/positions');
$showFab         = ($templateName !== 'job');
?>
<div>
	<?php if ($showFab): ?>
	<div fab data-scroll class="fixed inset__bottom-right inner__1" data-contact-hide>
		<div class="flex" style="--in-delay: 1000ms" data-reveal>
			<?php if ($isCareerLanding): ?>
				<a href="<?= $positionsUrl ?>" class="button bg__acc" theme="acc" hover="dark">
					<div icon class="grid__stack place__center-center color__invert ">
						<div class="grid place__center-center -wrap-l__01"><?= svg('public/assets/images/ui/ui_contact.svg') ?></div>
					</div>
					<label class="upper color__invert"><div>
						<span class="flex inner-r__1">Volné pozice (<?= $jobsCount ?>)</span>
					</div></label>
				</a>
			<?php elseif ($isJobsContext): ?>
				<button class="button bg__acc " theme="acc" hover="dark" data-contact-toggle="inquiry" >
					<div icon class="grid__stack place__center-center color__invert ">
						<div class="grid place__center-center -wrap-l__01"><?= svg('public/assets/images/ui/ui_contact.svg') ?></div>
					</div>
					<label class="upper color__invert"><div>
						<span class="flex inner-r__1">Mám zájem o pozici</span>
					</div></label>
				</button>
			<?php else: ?>
				<button class="button bg__acc " theme="acc" hover="dark" data-contact-toggle >
					<div icon class="grid__stack place__center-center color__invert ">
						<div class="grid place__center-center -wrap-l__01"><?= svg('public/assets/images/ui/ui_contact.svg') ?></div>
					</div>
					<label class="upper color__invert"><div>
						<span class="flex inner-r__1">Poptat projekt</span>
					</div></label>
				</button>
			<?php endif ?>
		</div>
	</div>
	<?php endif ?>
	<section class="contact fixed" data-scroll data-contact data-lenis-prevent>
		<div class="grid place__end-end inner__1 h__100v" >
			<?php if ($isCareerLanding || $isJobsContext): ?>
				<?php snippet('organisms/Contact/career') ?>
			<?php else: ?>
				<?php snippet('organisms/Contact/widget') ?>
			<?php endif ?>
		</div>
	</section>
</div>
