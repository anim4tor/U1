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
                <div class="grid col-span-2 p-0" data-scroll>
                    <?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect-[16/9]']) ?>
                </div>
                <?php 
            else: 
                ?>
                <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-2" data-scroll>
                	<div></div>
                	<div class="grid pr-10">
                    	<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect-[3/4]']) ?>
                	</div>
                </div>
                <?php 
            endif;
        endif;

    elseif ($isGallery):
		// 1. Safely retrieve the file object from the block
		if ($images = $block->images()->toFiles()): ?>
		  <div class="grid grid-cols-<?= $images->count() ?> gap-1 col-span-2 py-1">
		    <?php foreach ($images as $image): ?>
		     	<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'aspect-[3/4]']) ?>
		    <?php endforeach; ?>
		  </div>
		<?php endif;

    elseif ($isNewHeading):

        // Start a fresh, clean grid section wrapper
        $inGroup = true;
        ?>
        <div class="col-span-2 grid py-1 gap-2 border-t border-white/20" data-scroll>	
            <div class="grid grid-cols-2">
                <?= $block ?> 
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            	<div></div>
	            <!-- Content column wrapper for text, buttons, etc. -->
	            <div class="grid gap-1 pr-10">
        <?php 

    else:
        // Fallback: If content appears before any heading, start a group automatically
        if (!$inGroup):
            echo '<div class="grid gap-1 pr-10">';
            $inGroup = true;
        endif;
        ?>
        <div class="uppercase" data-reveal-text="lines">
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