<?php if (collection('Projects')->isNotEmpty()) : ?>
<section class="list" theme="invert">
	<ol class="grid grid-cols-1 md:grid-cols-3 gap-1 p-1 pb-5">
		<?php foreach ($projects as $project) : ?>
			<div data-slide class="pb-3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
	</ol>
</section>
<?php endif ?>
