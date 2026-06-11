<div class="grid">
	<section class="grid gap__0 place__start-stretch inner-x__1 wrap-t__5">
		<div class="relative" data-scroll>
			<?php if ($cover = $project->cover()->toFile()): ?>
			<div data-panel-reveal>
				<figure class="grid vh__10 " role="img" aria-labelledby="" data-reveal-image>
					<img class="absolute inset__0 " src="<?= $cover->url() ?>" alt="<?= $cover->alt()->esc() ?>" data-panel-img>
			    </figure>
			</div>
			<?php endif ?>
		</div>
		<figcaption class="grid gap__3 inner-x__1" data-scroll data-scroll-repeat>
			<div class="-wrap-t__3">
				<h1 data-panel-reveal class="font__size__1 s">PR.<?= formatNum($project->indexOf($portfolio) + 1) ?><br>/<?= formatNum($portfolio->count()) ?></h1>
			</div>
			<div class="mobile:grid__2 place__start-stretch gap__1 ">
				<div class="grid gap__0">
					<p data-panel-reveal class="mono">Name:</p>
					<p data-panel-reveal class="mono"><?= $project->title() ?></p>
				</div>
				<div class="grid gap__1">
					<div class="grid gap__0">
						<p data-panel-reveal class="mono">Authors:</p>
						<p data-panel-reveal class="mono"><?= $project->authors() ?></p>
					</div>
					<div class="grid">
						<p data-panel-reveal class="mono">Client:</p>
						<p data-panel-reveal class="mono"><?= $project->client() ?></p>
					</div>
					<div class="grid">
						<p data-panel-reveal class="mono">Type:</p>
						<p data-panel-reveal class="mono"><?= $project->type() ?></p>
					</div>
					<div class="grid">
						<p data-panel-reveal class="mono">Year:</p>
						<p data-panel-reveal class="mono"><?= $project->year()->toDate('Y') ?></p>
					</div>
				</div>
			</div>
		</figcaption>
		<figcaption class="grid gap__1 inner-x__1 inner-y__10" data-scroll data-scroll-repeat data-panel-content>
			<div class="grid">
				<p data-panel-reveal class="mono">Category:</p>
				<p data-panel-reveal class="mono">
					<?= implode(', ', $project->category()->split()); ?>
				</p>
			</div>
			
			<div class="grid gap__0">
				<p data-panel-reveal class="mono">Collab:</p>
				<p data-panel-reveal class="mono"><?= $project->collab() ?></p>
			</div>
			<div class="grid gap__0">
				<p data-panel-reveal class="mono">Desc:</p>
				<p data-panel-reveal class="mono"><?= $project->desc()->inline() ?></p>
			</div>
		</figcaption>
	</section>
	
	<section class="panel__gallery grid gap__5 inner-x__2 inner-b__5" >
		<?php $index = 1; ?>
		<?php $justify = ['start','center','end']; ?>
		<?php foreach($project->gallery()->toFiles() as $image): ?>
			<div class="panel__image grid" data-scroll data-scroll-repeat data-panel-reveal>
				<figure class="grid gap__05" role="img" aria-labelledby="caption4" data-reveal-image>
					<img src="<?= $image->crop(600, floor(600/$image->dimensions()->ratio()))->url() ?>" data-panel-img>
					<!-- <figcaption class="" >
						<div class="grid">
							<p data-reveal class="mono">Img.</p>
							<p data-reveal class="mono"><?= $index ?>/<?= $project->gallery()->toFiles()->count() ?></p>
						</div>
					</figcaption> -->
		        </figure>
			</div>
			<?php $index++; ?>
		<?php endforeach ?>
	</section>

	<section class="panel__next grid inner-y__10" >
		<div class="grid gap__0 place__center-center" data-scroll data-scroll-repeat >
			<h3 data-panel-reveal class="font__size__4">NXT PROJ</h3>
			<div data-panel-reveal class="mono flex align__center"><span class="icon inline"><img src="/public/assets/images/ui/ui_arrow-down.svg"></span></div>
		</div>
		<div class="grid inner-x__4 inner-y__10">
			<?= snippet('molecules/Project/next', [ 'project' => $next ]) ?>
		</div>
	</section>
</div>

