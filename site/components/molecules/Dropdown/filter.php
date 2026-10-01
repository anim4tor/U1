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
if ($sol    = get('solution'))   $currentQuery['solution']   = $sol;
if ($prod   = get('production')) $currentQuery['production'] = $prod;
if ($hash   = get('hash'))       $currentQuery['hash']       = $hash;
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
    $buttonLabel = $label . ' ▾';
} elseif ($countActive === 1 && !empty($activeLabels)) {
    $buttonLabel = $label . ' (' . $activeLabels[0] . ') ▾';
} else {
    $buttonLabel = $label . ' (' . $countActive . ') ▾';
}
$hiddenValue = implode(',', $activeSlugs);
?>
<div class="custom-dropdown" data-filter-param="<?= esc($param) ?>">
  <div class="dropdown-container relative">
    <?php if ($formMode) : ?>
      <input type="hidden" name="<?= esc($param) ?>" value="<?= esc($hiddenValue) ?>" data-form-filter-input="<?= esc($param) ?>">
    <?php endif ?>

    <?= snippet('atoms/Button', [ 
      'label'   => $buttonLabel, 
      'theme'   => $countActive > 0 ? 'dark' : ($theme ?? 'ghost'), 
      'reveal'  => true,
      'css'     => 'dropdown-toggle',
      'node'    => 'type="button" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="dropdown-label"'
    ]) ?>

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