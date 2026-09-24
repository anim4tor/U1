<article class="linkedin__card grid gap__05">
	<!-- Image & Link -->
	<a href="<?= $post->social_url() ?>" target="_blank" rel="noopener noreferrer" class="linkedin-image-link">
		<figure class="img__radius overlay__bottom relative color__invert aspect__1/1">
			<?php if ($post->media_url()->isNotEmpty()): ?>
				<img 
					src="<?= $post->media_url() ?>" 
					alt="<?= $post->title()->html() ?>" 
					loading="lazy"
				>
			<?php endif ?>
			<div class="badge absolute bottom__1 right__1 z__1">
				<?= svg('public/assets/images/linkedin.svg') ?>
			</div>
		</figure>
	</a>

	<!-- Post Content Details -->
	<div class="item__meta relative flex justify__space-between align__center gap__2">
		<?php if ($post->title()->isNotEmpty()): ?>
			<div class="flex gap__05 upper">
				<h3 class="font__size__4 wrap"><?= $post->title()->excerpt(200) ?></h3>
			</div>
		<?php endif ?>
	</div>
</article>