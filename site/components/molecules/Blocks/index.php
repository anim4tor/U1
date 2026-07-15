<?php
$inGroup = false; 
foreach ($blocks as $block): 
    $isLast = $block->isLast();
    $isImage = ($block->type() == 'image');
    $isNewHeading = ($block->type() == 'heading' && in_array($block->level(), ['h2', 'h3']));

    // --- STEP 1: MANAGE WRAPPERS ---
    // If we hit an image OR a new heading, close any active open group first
    if ($inGroup && ($isImage || $isNewHeading)):
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

    elseif ($isNewHeading):
        // Start a fresh, clean grid section wrapper
        $inGroup = true;
        ?>
        <div id="<?= Str::slug($block->text()->inline()) ?>" class="span__2 grid inner-y__1 gap__2 border__top" data-scroll>	
            <div class="grid__2">
                <h3 class="font__size__2 " data-reveal-text><?= $block->text() ?></h3>
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
            <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        </div>
        <?php 
    endif;

    // --- STEP 3: CLEAN UP TRAILING TAGS ---
    if ($isLast && $inGroup):
        echo '</div></div></div>'; // Your preferred closing tags
    endif;

endforeach; 
?>