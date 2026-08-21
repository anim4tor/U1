<article class="linkedin__card grid gap-05">
	<!-- Image & Link -->
	<a href="<?= $post->social_url() ?>" target="_blank" rel="noopener noreferrer" class="linkedin-image-link">
		<figure class="rounded-img overlay__bottom relative text-white">
			<?php if ($post->media_url()->isNotEmpty()): ?>
				<img 
					src="<?= $post->media_url() ?>" 
					alt="<?= $post->title()->html() ?>" 
					loading="lazy"
				>
			<?php endif ?>
			<div class="badge absolute bottom-1 right-1 z-10">
				<?= svg('public/assets/images/linkedin.svg') ?>
			</div>
		</figure>
	</a>

	<!-- Post Content Details -->
	<div class="item__meta relative flex justify-between items-center gap-2">
		<?php if ($post->title()->isNotEmpty()): ?>
			<div class="flex gap-05 uppercase">
				<h3 class="font-size-5 text-m flex-wrap"><?= $post->title()->excerpt(200) ?></h3>
			</div>
		<?php endif ?>
	</div>
</article>