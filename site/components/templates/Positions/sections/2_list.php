<?php if ($jobs->isNotEmpty()) : ?>
<section class="list" theme="invert">
	<ol class="grid__3 gap__1 inner__4 mobile:grid__1">
		<?php foreach ($jobs as $job) : ?>
			<div data-slide class="inner-b__3">
				<?= snippet('molecules/Job/card', compact('job')) ?>
			</div>
		<?php endforeach ?>
	</ol>
</section>
<?php else : ?>
<section class="list" theme="invert">
	<div class="inner__4 inner-y__5 op__4">
		<p>Momentálně nemáme žádné otevřené pozice.</p>
	</div>
</section>
<?php endif ?>
