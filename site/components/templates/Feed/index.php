<div class="feed-page" data-tabs="default">
	<?= snippet('templates/globals/Hero/list', [
		'theme' => 'invert',
		'tabs'  => [
			['id' => 'blog',    'label' => 'Články', 'count' => collection('Blog')->count()],
			['id' => 'socials', 'label' => 'Sítě',   'count' => collection('Socials')->count()],
			['id' => 'media',   'label' => 'Média',  'count' => collection('Projects')->count()],
		]
	]) ?>

	<div data-pane-container class="relative z__1">
		<!-- 1. Blog Tab -->
		<div data-pane="blog" data-tab-reveal class="w__full">
			<ol class="grid__3 gap__1 inner__4 inner-t__2 mobile:grid__1">
				<?php foreach (collection('Blog') as $feed) : ?>
					<li class="inner-b__3" data-scroll>
						<?= snippet('molecules/Feed', compact('feed')) ?>
					</li>
				<?php endforeach ?>
			</ol>
		</div>

		<!-- 2. Socials Tab -->
		<div data-pane="socials" data-tab-reveal class="w__full">
			<ol class="grid__3 gap__1 inner__4 inner-t__2 mobile:grid__1">
				<?php foreach (collection('Socials') as $post) : ?>
					<li class="inner-b__3" data-scroll>
						<?= snippet('molecules/Feed/social', compact('post')) ?>
					</li>
				<?php endforeach ?>
			</ol>
		</div>

		<!-- 3. Media Tab -->
		<div data-pane="media" data-tab-reveal class="w__full">
			<ol class="grid__3 gap__1 inner__4 inner-t__2 mobile:grid__1">
				<?php foreach (collection('Projects') as $feed) : ?>
					<li class="inner-b__3" data-scroll>
						<?= snippet('molecules/Feed/media', compact('feed')) ?>
					</li>
				<?php endforeach ?>
			</ol>
		</div>
	</div>
</div>

<?= snippet('templates/globals/Cta') ?>