<body page="<?= $page ?>" theme="light" >
    
    <?= $site->seobodyscripts() ?>

    <!-- The loader -->
    <?php snippet('organisms/Loader') ?>

    <!-- The aside --> 
    <?php snippet('organisms/Aside'); ?>

    <!-- The booking widget --> 
    <?php snippet('organisms/Booking'); ?>
    
    <!-- Scroll container -->
    <main id="top" data-scroll-content>

      <!-- The header --> 
      <?php snippet('organisms/Header'); ?>

      <?php if ($main = $slots->main()): ?>
        <!-- The main --> 
        <?= $main ?>
      <?php endif ?>
      
      <!-- The footer --> 
      <?php snippet('organisms/Footer'); ?>

    </main>

    
</body>

