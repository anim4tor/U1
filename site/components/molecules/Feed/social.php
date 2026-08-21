<article class="social__card social__card--<?= $post->platform() ?> grid gap__05">
	<!-- Image & Link -->
	<a href="<?= $post->social_url() ?>" target="_blank" rel="noopener noreferrer" class="social-image-link">
		<figure class="img__radius overlay__bottom relative color__invert">
			<?php if ($post->media_url()->isNotEmpty()): ?>
				<img 
					src="<?= $post->media_url() ?>" 
					alt="<?= $post->title()->html() ?>" 
					loading="lazy"
				>
			<?php endif ?>

			<!-- Platform SVG Badge -->
			<div class="badge absolute bottom__1 right__1 z__1">
				<?= svg('public/assets/images/' . $post->platform() . '.svg') ?>
			</div>

			<!-- Video Badge (Instagram only) -->
			<?php if ($post->media_type()->value() === 'VIDEO'): ?>
				<span class="video-badge absolute top__1 right__1 z__1">▶ Video</span>
			<?php endif ?>
		</figure>
	</a>

	<!-- Post Content Details -->
	<div class="item__meta relative flex justify__space-between align__center gap__2">
		<?php if ($post->title()->isNotEmpty()): ?>
			<div class="flex gap__05 upper">
				<h3 class="font__size__5 text-m wrap"><?= $post->title()->excerpt(200) ?></h3>
			</div>
		<?php endif ?>

		<!-- <?php if ($post->hashtags()->isNotEmpty()): ?>
			<p class="hashtags">
				<?php foreach ($post->hashtags()->split() as $tag): ?>
					<span class="hashtag">#<?= $tag ?></span>
				<?php endforeach ?>
			</p>
		<?php endif ?> -->
	</div>
</article>