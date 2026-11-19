<?php
$param       = $param ?? 'filter';
$rawActive   = $active ?? get($param);
$targetPage  = $page ?? (function_exists('page') && page() ? page() : null);
$baseUrl     = $targetPage ? $targetPage->url() : url('projects');
$formMode    = $formMode ?? false;

// Parse active values into an array of slugs
if (is_array($rawActive)) {
    $activeSlugs = array_values(array_filter($rawActive));
} else {
    $activeSlugs = array_values(array_filter(explode(',', (string)$rawActive)));
}

// Gather current active query parameters
$currentQuery = [];
if ($ind    = get('industry'))   $currentQuery['industry']   = $ind;
if ($sp     = get('space'))      $currentQuery['space']      = $sp;
if ($cl     = get('client'))     $currentQuery['client']     = $cl;
if ($sol    = get('solution'))   $currentQuery['solution']   = $sol;
if ($prod   = get('production')) $currentQuery['production'] = $prod;
if ($hash   = get('hash'))       $currentQuery['hash']       = $hash;
if ($y      = get('year'))       $currentQuery['year']       = $y;
if ($f      = get('filter'))     $currentQuery['filter']     = $f;
if ($search = get('search'))     $currentQuery['search']     = $search;
if ($q      = get('q'))          $currentQuery['q']          = $q;

$activeLabels = [];
if (!empty($activeSlugs) && !empty($options)) {
    foreach ($options as $opt) {
        if (in_array($opt['slug'] ?? '', $activeSlugs)) {
            $activeLabels[] = $opt['text'] ?? $opt['name'] ?? $opt['slug'];
        }
    }
}

$countActive = count($activeSlugs);
if ($countActive === 0) {
    $buttonLabel = $label;
} elseif ($countActive === 1 && !empty($activeLabels)) {
    $buttonLabel = $label . ' (' . $activeLabels[0] . ')';
} else {
    $buttonLabel = $label . ' (' . $countActive . ')';
}
$hiddenValue = implode(',', $activeSlugs);
?>
<div class="custom-dropdown" data-filter-param="<?= esc($param) ?>">
  <div class="dropdown-container relative">
    <?php if ($formMode) : ?>
      <input type="hidden" name="<?= esc($param) ?>" value="<?= esc($hiddenValue) ?>" data-form-filter-input="<?= esc($param) ?>">
    <?php endif ?>

    <button 
      type="button" 
      class="button font__size__button dropdown-toggle flex align__center justify__space-between" 
      theme="<?= $countActive > 0 ? 'dark' : ($theme ?? 'ghost') ?>" 
      hover="dark"
      aria-haspopup="listbox" 
      aria-expanded="false"
    >
      <span class="dropdown-toggle__label"><?= esc($buttonLabel) ?></span>
      <span class="dropdown-toggle__chevron flex align__center justify__center" aria-hidden="true">
        <svg viewBox="0 0 10 6" width="10" height="6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M1 1l4 4 4-4" />
        </svg>
      </span>
    </button>

    <ul class="dropdown-menu" role="listbox" theme="light" data-lenis-prevent>
      <?php foreach ($options as $tag) : ?>
        <?php
          $tagQuery = $currentQuery;
          unset($tagQuery['filter']);
          $isActive = in_array($tag['slug'], $activeSlugs);

          if ($isActive) {
              $remaining = array_values(array_diff($activeSlugs, [$tag['slug']]));
              if (!empty($remaining)) {
                  $tagQuery[$param] = implode(',', $remaining);
              } else {
                  unset($tagQuery[$param]);
              }
          } else {
              $newSlugs = array_merge($activeSlugs, [$tag['slug']]);
              $tagQuery[$param] = implode(',', $newSlugs);
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
            <span class="flex align__center gap__05">
              <span class="dropdown-checkmark col__acc font__size__small <?= $isActive ? '' : 'is-hidden' ?>">✓</span>
              <span class="dropdown-option-text"><?= esc($tag['text']) ?></span>
            </span>
          </button>
        <?php else : ?>
          <a 
            href="<?= esc($url) ?>" 
            class="button upper justify__start <?= $isActive ? 'is-active' : '' ?>" 
            theme="<?= $isActive ? 'dark' : 'light' ?>" 
            data-ajax-filter="true"
            role="option"
            aria-selected="<?= $isActive ? 'true' : 'false' ?>"
          >
            <span class="flex align__center gap__05">
              <span class="dropdown-checkmark col__acc font__size__small <?= $isActive ? '' : 'is-hidden' ?>">✓</span>
              <span class="dropdown-option-text"><?= esc($tag['text']) ?></span>
            </span>
          </a>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
  </div>
</div>