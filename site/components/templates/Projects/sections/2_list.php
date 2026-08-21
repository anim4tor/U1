<?php if (collection('Projects')->isNotEmpty()) : ?>
<section class="list" theme="invert">
	<ol class="grid__3 gap__1 inner__1 inner-b__5">
		<?php foreach ($projects as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
	</ol>
</section>
<?php endif ?>
