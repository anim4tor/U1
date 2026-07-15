<!-- Vendor js -->

<!-- The cookie elements --> 
<!-- <script type="module" src="/assets/js/cookieconsent-config.js"></script> -->

<!-- Global js -->
<!-- <script src="/site/components/organisms/Aside/index.js"></script> -->
<?= js('public/assets/js/app.dist.js'); ?>
<!-- <script src="/public/assets/js/app.dist.js"></script> -->

<!-- Local js -->
<?= js('site/components/templates/'.ucwords($page->intendedTemplate()).'/index.js'); ?>