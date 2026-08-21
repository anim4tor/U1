<article class="instagram__card grid gap-05">
	<!-- Image & Permalink -->
    <a href="<?= $post->social_url() ?>" target="_blank" rel="noopener noreferrer" class="instagram-image-link">
      <figure class="rounded-img overlay__bottom relative text-white">
	      <img 
	        src="<?= $post->media_url() ?>" 
	        alt="<?= $post->title()->html() ?>" 
	        loading="lazy"
	      >
	      <div class="badge absolute bottom-1 right-1 z-10">
	      	<?= svg('public/assets/images/instagram.svg') ?>
	      </div>
	      <?php if ($post->media_type()->value() === 'VIDEO'): ?>
	        <span class="video-badge">▶ Video</span>
	      <?php endif ?>
      </figure>
    </a>
	<!-- Post Content Details -->
	<div class="item__meta relative flex justify-between items-center gap-2">
		<?php if ($post->title()->isNotEmpty()): ?>
		<div class="flex gap-05 uppercase">
			<h3 class="font-size-5 text-m flex-wrap"><?= $post->title()->excerpt(200) ?></h3>
		</div>
		<?php endif ?>
		<!-- <?php if ($post->hashtags()->isNotEmpty()): ?>
		<p class="">
			<?php foreach ($post->hashtags()->split() as $tag): ?>
			  <span class="hashtag">#<?= $tag ?></span>
			<?php endforeach ?>
		</p>
		<?php endif ?> -->
	</div>

</article>