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
                <div class="grid span__2 inner__0" data-scroll>
                    <?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__16/9']) ?>
                </div>
                <?php 
            else: 
                ?>
                <div class="span__2 grid grid__post gap__2" data-scroll>
                	<div></div>
                	<div class="grid inner-r__10">
                    	<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__3/4']) ?>
                	</div>
                </div>
                <?php 
            endif;
        endif;

    elseif ($isGallery):
		// 1. Safely retrieve the file object from the block
		if ($images = $block->images()->toFiles()): ?>
		  <div class="grid__<?= $images->count() ?> gap__1 span__2 inner-y__1">
		    <?php foreach ($images as $image): ?>
		     	<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect__3/4']) ?>
		    <?php endforeach; ?>
		  </div>
		<?php endif;

    elseif ($isNewHeading):

        // Start a fresh, clean grid section wrapper
        $inGroup = true;
        ?>
        <div class="span__2 grid inner-y__1 gap__2 border__top" data-scroll>	
            <div class="grid__2">
                <?= $block ?> 
            </div>
            <div class="grid grid__post gap__2 ">
            	<div></div>
	            <!-- Content column wrapper for text, buttons, etc. -->
	            <div class="grid gap__1 inner-r__10">
        <?php 

    else:
        // Fallback: If content appears before any heading, start a group automatically
        if (!$inGroup):
            echo '<div class="grid gap__1 inner-r__10">';
            $inGroup = true;
        endif;
        ?>
        <div class="upper" data-reveal-text="lines">
            <?= $block ?> 
        </div>
        <?php 
    endif;

    // --- STEP 3: CLEAN UP TRAILING TAGS ---
    if ($isLast && $inGroup):
        echo '</div></div></div>'; // Your preferred closing tags
    endif;

endforeach; 
?>