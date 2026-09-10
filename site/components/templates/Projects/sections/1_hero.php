<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro relative z__2" theme="invert" style="--in-delay: 500ms">
	<div class="z__1 relative intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__1 inner-x__4 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__2"></div>
		<div class="span__4 inner-y__1 border__bottom flex justify__space-between align__end">
			<div class="span__2">
				<div class="flex align__start  gap__02 inner-y__02">
					<?php if (!empty($isFiltered)) : ?>
						<?php 
						// Find clean display text for active filters
						$activeLabels = [];
						if (!empty($filterIndustry)) {
							foreach ($industries as $item) {
								if ($item['slug'] === $filterIndustry) {
									$activeLabels[] = $item['text'];
									break;
								}
							}
						}
						if (!empty($filterSpace)) {
							foreach ($spaces as $item) {
								if ($item['slug'] === $filterSpace) {
									$activeLabels[] = $item['text'];
									break;
								}
							}
						}
						if (empty($activeLabels) && !empty($filterGeneric)) {
							$allTags = array_merge($industries, $spaces);
							foreach ($allTags as $item) {
								if ($item['slug'] === $filterGeneric) {
									$activeLabels[] = $item['text'];
									break;
								}
							}
						}
						$activeHeading = !empty($activeLabels) ? implode(' / ', $activeLabels) : 'Filtered';
						?>
						<?= snippet('atoms/Heading', [
							'text'   => $activeHeading, 
							'level'  => 'h1',
							'reveal' => true
						]) ?>

					<?php else : ?>
						<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
					<?php endif ?>
					<?php 
						$itemCount = (!empty($isFiltered) && isset($images)) ? $images->pagination()->total() : $projects->pagination()->total(); 
					?>
					<?= snippet('atoms/Text', ['text' => '('.$itemCount.')', 'reveal' => true, 'css' => 'font__size__4' ]) ?>
				</div>
			</div>
			<div></div>
			<div class="flex justify__end gap__05 align__center" data-scroll>
				<div class="flex align__start gap__05 ">
				<?= snippet('atoms/Button', [ 
			        'url'     => $page->url(), 
			        'label'   => 'All', 
			        'theme'   => empty($isFiltered) ? 'dark' : 'light', 
			        'reveal'  => true
			    ]) ?>
			    <?= snippet('molecules/Dropdown/filter', [ 
					'label'   => 'Industries', 
					'param'   => 'industry',
					'options' => $industries,
					'active'  => $filterIndustry ?? null
				]) ?> 
			    <?= snippet('molecules/Dropdown/filter', [ 
					'label'   => 'Spaces', 
					'param'   => 'space',
					'options' => $spaces,
					'active'  => $filterSpace ?? null
				]) ?> 
				</div>
			</div>
		</div>
		
	</div>
</section>
<?php endif ?>