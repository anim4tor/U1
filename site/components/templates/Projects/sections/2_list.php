<?php if (collection('Projects')->isNotEmpty()) : ?>
<section class="list" theme="invert">
	<div class="flex gap__05 inner-x__1 inner-y__1 border__bottom" data-scroll>
		<?= snippet('atoms/Button', [ 
		        'url'     => $page, 
		        'label'   => 'All', 
		        'theme'   => 'light', 
		        'reveal'  => true
		    ]) ?>
		<?php foreach ($tags as $tag) : ?>
			<?= snippet('atoms/Button', [ 
		        'url'     => $page . '?filter='. $tag['slug'], 
		        'label'   => $tag['text'], 
		        'theme'   => 'light', 
		        'reveal'  => true
		    ]) ?>
		<?php endforeach ?>
	</div>
	<ol class="grid__2 gap__1 inner__1 inner-b__5">
		<?php foreach ($projects as $project) : ?>
			<div data-slide class="inner-b__3">	
				<?= snippet('molecules/Project/large', compact('project')) ?>
			</div>
		<?php endforeach ?>
	</ol>
</section>
<?php endif ?>
