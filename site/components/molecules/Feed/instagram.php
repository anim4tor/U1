<article class="instagram__card grid gap__05">
	<!-- Image & Permalink -->
    <a href="<?= $post->social_url() ?>" target="_blank" rel="noopener noreferrer" class="instagram-image-link">
      <figure class="img__radius overlay__bottom relative color__invert aspect__1/1">
	      <img 
	        src="<?= $post->media_url() ?>" 
	        alt="<?= $post->title()->html() ?>" 
	        loading="lazy"
	      >
	      <div class="badge absolute bottom__1 right__1 z__1">
	      	<?= svg('public/assets/images/instagram.svg') ?>
	      </div>
	      <?php if ($post->media_type()->value() === 'VIDEO'): ?>
	        <span class="video-badge">▶ Video</span>
	      <?php endif ?>
      </figure>
    </a>
	<!-- Post Content Details -->
	<div class="item__meta relative flex justify__space-between align__center gap__2">
		<?php if ($post->title()->isNotEmpty()): ?>
		<div class="flex gap__05 upper ">
			<h3 class="font__size__4 wrap"><?= $post->title()->excerpt(200) ?></h3>
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