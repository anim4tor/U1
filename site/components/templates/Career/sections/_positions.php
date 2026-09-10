<?php if (collection('Jobs')->isNotEmpty()) : ?>
<section id="opened-positions" class="positions radius inner-t__5" theme="invert">
	<div class="grid inner-x__1">
		<div class="grid__3 gap__2 mobile:grid__1 inner-y__1 mobile:inner-x__1 ">
			<div class="span__2">
				<?= snippet('molecules/Header', ['header' => $page->positions(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex gap__02 justify__end align__end " data-scroll>
				<div class="font__size__3" data-reveal-text>
					(<?= collection('Jobs')->count() ?>)
				</div>
			</div>
		</div>
		<div class="grid__3 gap__2 mobile:grid__1 inner-b__5 mobile:inner-x__1 ">
			<ol class="span__3 grid" >	
				<?php foreach (collection('Jobs') as $job) : ?>
					<?= snippet('molecules/Job', compact('job')) ?>
				<?php endforeach ?>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>
