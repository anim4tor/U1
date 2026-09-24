<?php
$inGroup = false; 
foreach ($blocks as $block): 
    $isLast = $block->isLast();
    $isImage = ($block->type() == 'image');
    $isGallery = ($block->type() == 'gallery');
    $isNewHeading = ($block->type() == 'line' || $block->type() == 'heading' && in_array($block->level(), ['h2']));

    // --- STEP 1: MANAGE WRAPPERS ---
    // If we hit an image OR a new heading, close any active open group first
    if ($inGroup && ($isGallery || $isImage || $isNewHeading)):
        echo '</div></div></div>'; // Your preferred closing tags
        $inGroup = false;
    endif;

    // --- STEP 2: RENDER BLOCKS ---
    if ($isImage):
        // 1. Safely retrieve the file object from the block
        if ($image = $block->image()->toFile()): 
            // 2. Render based on orientation
            if ($image->orientation() == "landscape"): 
                ?>
                <div class="grid inner__0" data-scroll>
                    <?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__16/9']) ?>
                </div>
                <?php 
            else: 
                ?>
                <div class="grid__2 gap__2" data-scroll>
                	<div></div>
                	<div class="grid inner-r__5">
                    	<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__3/4']) ?>
                	</div>
                </div>
                <?php 
            endif;
        endif;

    elseif ($isGallery):
		// 1. Safely retrieve the file object from the block
		if ($images = $block->images()->toFiles()): ?>
		  <div class="grid__<?= $images->count() ?> gap__1 inner-y__1">
		    <?php foreach ($images as $image): ?>
		     	<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__3/4']) ?>
		    <?php endforeach; ?>
		  </div>
		<?php endif;

    elseif ($isNewHeading):

        // Start a fresh, clean grid section wrapper
        $inGroup = true;
        ?>
        <div class="grid__4 gap__2" data-scroll>	
            <div data-scroll class="flex align__start gap__01 span__2 inner-r__5 relative ">
                <div class="absolute -left__03 w__03 h__03 bg__acc"></div>
                <?= $block ?> 
            </div>
            <div class="grid gap__2 span__2">
            	<!-- <div></div> -->
	            <!-- Content column wrapper for text, buttons, etc. -->
	            <div class="grid gap__1 inner-r__5">
        <?php 

    else:
        // Fallback: If content appears before any heading, start a group automatically
        if (!$inGroup):
            echo '<div class="grid gap__1 inner-r__5">';
            $inGroup = true;
        endif;
        ?>
        <?= $block ?>
        <?php 
    endif;

    // --- STEP 3: CLEAN UP TRAILING TAGS ---
    if ($isLast && $inGroup):
        echo '</div></div></div>'; // Your preferred closing tags
    endif;

endforeach; 
?>