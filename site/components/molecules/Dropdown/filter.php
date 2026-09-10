<?php
$param       = $param ?? 'filter';
$activeValue = $active ?? get($param);

// Gather current active query parameters
$currentQuery = [];
if ($ind = get('industry')) $currentQuery['industry'] = $ind;
if ($sp  = get('space'))    $currentQuery['space']    = $sp;
if ($f   = get('filter'))   $currentQuery['filter']   = $f;
?>
<div class="custom-dropdown">
  <div class="dropdown-container relative">
    <?= snippet('atoms/Button', [ 
      'label'   => $label . ($activeValue ? ' (1)' : '') . ' ▾', 
      'theme'   => $activeValue ? 'dark' : 'light', 
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
          $url = $page->url() . ($queryString ? '?' . $queryString : '');
        ?>
        <?= snippet('atoms/Button', [ 
          'url'     => $url, 
          'label'   => ($isActive ? '✓ ' : '') . $tag['text'], 
          'theme'   => $isActive ? 'dark' : 'light',
          'css'     => 'justify__start',
          'reveal'  => true
        ]) ?>
      <?php endforeach ?>
    </ul>
  </div>
</div>