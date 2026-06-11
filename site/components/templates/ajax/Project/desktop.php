<div class="grid gap__5">
	<section class="panel__intro grid__4 gap__0 place__start-stretch inner-x__1">
		<figcaption class="panel__content grid place__center-stretch align__space-between grid__fullheight inner-y__5 inner-l__1" data-scroll data-scroll-repeat>
			<div></div>
			<h1 data-panel-reveal class="text-right">PR.<?= formatNum($project->indexOf($portfolio) + 1) ?><br>/<?= formatNum($portfolio->count()) ?></h1>
			<div class="grid__2 gap__1 place__end-stretch justify__space-between align__end">
				<div class="grid">
					<p data-panel-reveal class="mono">Client:</p>
					<p data-panel-reveal class="mono"><?= $project->client() ?></p>
				</div>
				<div class="grid">
					<p data-panel-reveal class="mono">Type:</p>
					<p data-panel-reveal class="mono"><?= $project->type() ?></p>
				</div>
				<div class="grid">
					<p data-panel-reveal class="mono">Category:</p>
					<p data-panel-reveal class="mono">
						<?= implode(', ', $project->category()->split()); ?>
					</p>
				</div>
				<div class="grid">
					<p data-panel-reveal class="mono">Year:</p>
					<p data-panel-reveal class="mono"><?= $project->year()->toDate('Y') ?></p>
				</div>
			</div>
		</figcaption>
		<div class="span__2 grid inner-x__2 inner-t__5" data-scroll data-scroll-repeat>
			<?php if ($cover = $project->cover()->toFile()): ?>
			<div data-panel-reveal>		
				<figure class="panel__image" role="img" aria-labelledby="" data-reveal-image>
					<img class="" src="<?= $cover->url() ?>" alt="<?= $cover->alt()->esc() ?>" data-panel-img>
			    </figure>
			</div>
			<?php endif ?>
		</div>
		<figcaption class="panel__content grid gap__1 place__end-start align__end grid__fullheight inner-y__5 inner-r__1" data-scroll data-scroll-repeat data-panel-content>
			<span></span>
			<div class="grid gap__0">
				<p data-panel-reveal class="mono">Name:</p>
				<p data-panel-reveal class="mono"><?= $project->title() ?></p>
			</div>
			<div class="grid gap__0">
				<p data-panel-reveal class="mono">Authors:</p>
				<p data-panel-reveal class="mono"><?= $project->authors() ?></p>
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
	
	<section class="panel__gallery grid gap__5 inner-x__5 inner-b__5" >
		<?php $index = 1; ?>
		<?php $justify = ['start','center','end']; ?>
		<?php foreach($project->gallery()->toFiles() as $image): ?>
			<div class="panel__image grid justify__<?= $justify[array_rand($justify)] ?>" data-scroll data-scroll-repeat data-panel-reveal>
				<figure class="flex place__start-end gap__0" role="img" aria-labelledby="caption4" data-reveal-image >
					<img src="<?= $image->url() ?>" data-panel-img>
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

	<section class="panel__next ">
		<div class="grid gap__0 place__center-center" data-scroll>
			<h3 data-panel-reveal class="font__size__5">NXT PROJECT</h3>
			<div data-panel-reveal class="mono flex align__center"><span class="icon inline"><img src="/public/assets/images/ui/ui_arrow-down.svg"></span>Scroll</div>
		</div>
		<div class="grid grid__fullheight place__center-center" data-scroll data-scroll-progress data-scroll-position='start, start' data-scroll-offset="50%,0%">
			<a href="<?= $next->url() ?>" data-fetch="/ajax/project/<?= $next->slug() ?>" class="grid inner-x__1 inner-y__0" data-next >
				<div class="grid__4" >
					<figcaption class="panel__content grid place__center-stretch align__space-between inner-x__1" data-scroll data-scroll-repeat>
						<div></div>
						<h1 class="grid text-right" data-panel-reveal>
							<span data-scroll-reveal >PR.<?= formatNum($next->indexOf($portfolio) + 1) ?></span>
							<span data-scroll-reveal >/<?= formatNum($portfolio->count()) ?></span>
						</h1>
						<div></div>
					</figcaption>
					<div class="span__2 grid place__center-center inner-x__7" data-scroll data-scroll-repeat>
						<?php if ($cover = $next->cover()->toFile()): ?>
						<div data-panel-reveal>
							<figure class="project__image" role="img" aria-labelledby="" data-reveal-image>
								<img class="" src="<?= $cover->crop(1000)->url() ?>" alt="<?= $cover->alt()->esc() ?>" data-panel-img >
						    </figure>
						</div>
						<?php endif ?>
					</div>
					<figcaption class="panel__content grid gap__2 place__center-start inner-r__1" data-scroll data-scroll-repeat data-panel-content>
						<div class="grid gap__0">
							<p data-panel-reveal class="mono">Name:</p>
							<p data-panel-reveal class="mono"><?= $next->title() ?></p>
							<div data-panel-reveal>
								<p class="mono" data-project-loader>Img. <span data-project-loader-progress>00</span></p>
							</div>

						</div>
					
					</figcaption>
				</div>
			</a>
		</div>
	</section>
</div>

