<a href class="instructor grid gap__05 inner-b__2">
	<?php if ($photo = $instructor->photo()->toFile()) : ?>
		<figure class="grid h__15 mobile:h__auto"><?= snippet('atoms/Image', [ 'img' => $photo ]) ?></figure>
	<?php endif ?>
	<p class="flex gap__02 align__center">
		<span><?= $instructor->title() ?></span>
		<span class="xs op__5">•</span> 
		<span class="op__5"><?= implode(', ', $instructor->lectures()->split()) ?></span>
	</p>
</a>