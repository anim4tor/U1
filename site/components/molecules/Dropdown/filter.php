<?php
$param       = $param ?? 'filter';
$activeValue = $active ?? get($param);
$targetPage  = $page ?? (function_exists('page') && page() ? page() : null);
$baseUrl     = $targetPage ? $targetPage->url() : url('projects');
$formMode    = $formMode ?? false;

// Gather current active query parameters
$currentQuery = [];
if ($ind    = get('industry'))   $currentQuery['industry']   = $ind;
if ($sp     = get('space'))      $currentQuery['space']      = $sp;
if ($sol    = get('solution'))   $currentQuery['solution']   = $sol;
if ($prod   = get('production')) $currentQuery['production'] = $prod;
if ($hash   = get('hash'))       $currentQuery['hash']       = $hash;
if ($f      = get('filter'))     $currentQuery['filter']     = $f;
if ($search = get('search'))     $currentQuery['search']     = $search;
if ($q      = get('q'))          $currentQuery['q']          = $q;

$activeLabel = null;
if ($activeValue && !empty($options)) {
    foreach ($options as $opt) {
        if (($opt['slug'] ?? '') === $activeValue) {
            $activeLabel = $opt['text'] ?? $opt['name'] ?? null;
            break;
        }
    }
}
$buttonLabel = $activeLabel ? $label . ' (' . $activeLabel . ') ▾' : $label . ' ▾';
?>
<div class="custom-dropdown" data-filter-param="<?= esc($param) ?>">
  <div class="dropdown-container relative">
    <?php if ($formMode) : ?>
      <input type="hidden" name="<?= esc($param) ?>" value="<?= esc($activeValue ?? '') ?>" data-form-filter-input="<?= esc($param) ?>">
    <?php endif ?>

    <?= snippet('atoms/Button', [ 
      'label'   => $buttonLabel, 
      'theme'   => $activeValue ? 'dark' : ($theme ?? 'ghost'), 
      'reveal'  => true,
      'css'     => 'dropdown-toggle',
      'node'    => 'type="button" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="dropdown-label"'
    ]) ?>

    <ul class="dropdown-menu" role="listbox" theme="light" data-lenis-prevent>
      <?php foreach ($options as $tag) : ?>
        <?php
          $tagQuery = $currentQuery;
          unset($tagQuery['filter']);
          $isActive = ($activeValue === $tag['slug']);

          if ($isActive) {
              unset($tagQuery[$param]);
          } else {
              $tagQuery[$param] = $tag['slug'];
          }

          $queryString = http_build_query($tagQuery);
          $url = $baseUrl . ($queryString ? '?' . $queryString : '');
        ?>
        <?php if ($formMode) : ?>
          <button 
            type="button" 
            class="button upper justify__start <?= $isActive ? 'is-active' : '' ?>" 
            theme="<?= $isActive ? 'dark' : 'light' ?>" 
            data-form-filter-option="<?= esc($tag['slug']) ?>"
            data-form-filter-label="<?= esc($tag['text']) ?>"
            data-form-filter-base-label="<?= esc($label) ?>"
          >
            <span aria-label="<?= esc($tag['text']) ?>"><?= ($isActive ? '✓ ' : '') . $tag['text'] ?></span>
          </button>
        <?php else : ?>
          <?= snippet('atoms/Button', [ 
            'url'     => $url, 
            'label'   => ($isActive ? '✓ ' : '') . $tag['text'], 
            'theme'   => $isActive ? 'dark' : 'light',
            'css'     => 'justify__start',
            'reveal'  => true,
            'node'    => 'data-ajax-filter="true"'
          ]) ?>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
  </div>
</div>