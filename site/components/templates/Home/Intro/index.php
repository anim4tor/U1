<section class="intro radius" theme="dark" data-tabs>
	<div class="hidden">
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-tab="project-<?= $project->indexOf(collection('Projects')) ?>"></div>
		<?php endforeach ?>
	</div>
	<div data-pane-container class="grid__stack absolute inset__stretch" >
		<?php foreach (collection('Projects') as $project) : ?>
			<?php if ($cover = $project->cover()->toFile()) : ?>
			<div data-tab-reveal data-pane="project-<?= $project->indexOf(collection('Projects')) ?>" >
				<div class="intro__cover grid " data-reveal-cover><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
			</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>
	<div class="z__1 intro__header grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__4 grid__4 inner-t__3 relative flex justify__space-between align__center" data-scroll data-scroll-ignore>
			<div class="upper s" data-tab-next>Featured project</div>
			<div class="span__2 grid__stack" data-pane-container>
				<?php foreach (collection('Projects') as $project) : ?>
					<?php if ($cover = $project->cover()->toFile()) : ?>
					<div data-pane="project-<?= $project->indexOf(collection('Projects')) ?>" class="grid__2" data-tab-reveal>
						<a href="<?= $project->url() ?>"><div data-reveal-text="words" data-split-ignore class="upper s"><?= $project->title() ?></div></a>
						<div data-reveal-text="words" data-split-ignore class="upper s flex justify__end"><?= $project->date()->toDate('Y') ?></div>
					</div>	
					<?php endif ?>
				<?php endforeach ?>
			</div>
			<div class="upper s flex justify__end" data-tab-next>(Next)</div>
		</div>
		<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" data-scroll style="--in-delay: 500ms">
			<h1 class="s">
				<div data-reveal-text="">We deliver <br> workspaces <br>that works</div>
			</h1>
		</div>
	</div>
</section>