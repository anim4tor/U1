<div class="grid gap__3 img__radius inner__1" theme="dark" >
	<div class="grid gap__1">
		<div class="grid gap__4 place__space-between-start">
			<div class="grid place__start-stretch gap__1">
				<p class="quote font__size__5 ff__heading wrap" data-reveal-text="lines" data-split-ignore>"<?= $project->testimonialQuote()->inline() ?>"</p>
			</div>
			<!-- <div class="flex justify__space-between">
				<div class="s upper " data-reveal-text="lines">David L.</div>
				<div class="s upper" data-reveal-text="lines">(Operations Manager)</div>
			</div> -->
		</div>
	</div>
	<div class="flex justify__space-between gap__05 align__end">
		<?php if ($project->testimonialImage()->isNotEmpty()) : ?>
			<div class="flex justify__space-between">
				<div class="no__overflow " >
					<?php if ($image = $project->testimonialImage()->toFile()) : ?>
						<div class="figure" data-reveal-image>
							<?= snippet('atoms/Image', ['img' => $image, 'parallax' => false, 'css' => 'max-w__4 max-h__5']) ?>
						</div>
					<?php endif ?>
				</div>
			</div>
		<?php endif ?>
		<div class="flex  gap__01">
			<div class="s upper op__4" data-reveal-text="lines"><?= $project->testimonialAuthor()->or($project->client()) ?></div>
			<?php if ($project->testimonialPosition()->isNotEmpty()) : ?>
				<div class="s upper op__4" data-reveal-text="lines">(<?= $project->testimonialPosition()->or($project->client()) ?>)</div>
			<?php endif ?>
		</div>
	</div>
</div>
