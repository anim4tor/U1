<?php
	$init = 0;
	switch ($page->intendedTemplate()) {
		case 'lectures':
		case 'lecture': {
			$init = 1;
			break;
		}
		case 'about':
		case 'instructor': {
			$init = 2;
			break;
		}
		case 'workshops':
			$init = 3;
			break;
		case 'events':
		case 'event': {
			$init = 4;
			break;
		}
		default:
			$init = 0;
			break;
	}
?>
<div fab data-scroll data-reveal style="--in-delay: 600ms">
	<button class="" data-scroll data-booking-toggle theme="dark" >
		<div class="grid__stack color__invert">
			<div data-booking-hide class="grid"><?= svg('public/assets/images/ui/ui_calendar.svg') ?></div>
			<div data-booking-reveal class="grid"><?= svg('public/assets/images/ui/ui_close.svg') ?></div>
		</div>
	</button>
</div>
<section class="booking" data-scroll data-booking data-lenis-prevent>
	<div class="grid place__end-end inner__1 h__100v" >
		<div class="grid place__start-stretch wrap__1" theme="light" data-booking-widget>
			
			<div data-tabs="">	
				<div data-pane-container>
					
					<div data-pane="calendar" data-active class="wider">
						<!-- <a data-tab="top" class="inner-y__05 inner-x__2 wrap-t__1 flex justify__start op__5"><div class="button upper -wrap-l__04 ">Back</div></a> -->

						<div class="inner-x__0">
							<iframe id="38f6a8799d7c775793897b5f6826eebf-fitness" src="https://studiocztest.sportimea.com/facilityplugin/StudioCZTEST/38f6a8799d7c775793897b5f6826eebf/fitness" width="100%" height="800" scrolling="auto" frameborder=0 seamless="seamless" allowfullscreen="true" allow="payment" allowpaymentrequest="true"></iframe>
							<script>
							window.onmessage = e => {
							  // Handle dynamic height adjustment
							  if (e.data.hasOwnProperty("sportimeaFrameHeight")) {
							    document.getElementById("38f6a8799d7c775793897b5f6826eebf-fitness").style.height = `${e.data.sportimeaFrameHeight + 30}px`;
							    var widget = document.querySelector('[data-booking] [data-pane-container]');
							    widget.style.height = `${e.data.sportimeaFrameHeight + 30}px`;
							  }
							  
							  // Handle frame reloading
							  if (e.data.hasOwnProperty("sportimeaFrameReload") && e.data.sportimeaFrameReload) {
							    document.getElementById("38f6a8799d7c775793897b5f6826eebf-fitness").src = document.getElementById("38f6a8799d7c775793897b5f6826eebf-fitness").src;
							  }
							  
							  // Handle URL redirects
							  if (e.data.hasOwnProperty("sportimeaFrameUrlOpen") && e.data.sportimeaFrameUrlOpen) {
							    window.location.href = e.data.sportimeaFrameUrlOpen;
							  }
							};
							</script>
						</div>
						
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
