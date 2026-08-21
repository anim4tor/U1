<div class="custom-dropdown">
  <div class="dropdown-container relative">
    <?= snippet('atoms/Button', [ 
      'label'   => $label . ' ▾', 
      'theme'   => 'light', 
      'reveal'  => true,
      'css'     => 'dropdown-toggle',
      'node'    => 'type="button" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="dropdown-label"'
    ]) ?>

    <ul class="dropdown-menu" role="listbox" theme="light" data-lenis-prevent>
      <?php foreach ($options as $tag) : ?>
        <?= snippet('atoms/Button', [ 
          'url'     => $page . '?filter=' . $tag['slug'], 
          'label'   => $tag['text'], 
          'css' => 'justify-start',
          'reveal'  => true
        ]) ?>
      <?php endforeach ?>
    </ul>
  </div>
</div>