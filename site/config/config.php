<?php

return [
    'debug'  => true,
    'panel.install' => true,
    'home' => 'home',
    'languages' => true,
    'colors' => [
        '#f4ee32' => 'neon',
        '#ddf432' => 'lime',
        '#f4cd32' => 'yellow',
        '#f49a32' => 'orange',
        '#db6b57' => 'red',
        '#db5f7e' => 'crimson',
        '#d56ff7' => 'pink',
        '#986ff7' => 'purple',
        '#034dbc' => 'blue',
        '#b3bae7' => 'violet',
        '#afbec8' => 'grey',
        '#7fc2db' => 'marine',
        '#11b5bb' => 'cyan',
    ],
    'cache' => [
        'social' => true
    ],
    'panel' => [
        'css' => 'public/assets/css/panel.custom.css'
    ],
    'instagram.token' => 'IGAARfnJ3rbYlBZAFpvSVZAGSGFLTVFMXzFRUm9kdmlQQzZArS2x6dkFQOUVkWDRDbGJSaWVDOEpXbDFQTldfSWoySkJJd29JNEpWREVweWd5RldwQU9HUV94eTdGeVUtRzJ0TDExVnVzZA2NmdnM2S19uMVlEY21kS2NKQVNZAU1VHSQZDZD',
    'linkedin.org_id' => 'urn:li:organization:18790224',
    'linkedin.token' => 'AQVpka3Ei6QC9lPfNKFV7-p8yoTpCkXZuHz8sAhn002y7QKqK5MJo92OJhjvlw57dtxyfJFNZOf3e-A1n__OjBZZVUvlwtMDUmuABUv1s_D3tWTOXOLok68uVeBbWVQL6AyX6NHnWDB9_lHq9yEbPNfjZgxF9a0kzfoqBgn2Oy1Nw7Vf2wNJS9cxWjrM-iEGNb8baTIWNMexMSCqNagDo0zY6OvedKmPcYkQmDXnXdV09kWel7LjWS2eMXRy3j9k8_rOwF0r881Utv7dxk1i6nDXd8g__YBlbj9ww1VI80sojS8jVRVNKalhXyNvYTOLFjbtXIigc10sN6VjS2lM1l_IZaZL3Q',
    'u1.git-content' => [
        'enabled'  => true,
        'repo'     => 'anim4tor/U1',
        'token'    => base64_decode('Z2hwXzNCRGY0bWE5R0t5Tk1ieXBvMGxQZnRVVW45ajJQcTRnSVp1UA=='),
        'branches' => ['content', 'design', 'v1', 'v2', 'v3', 'main'],
        'secret'   => 'maiden37',
        'author'   => [
            'name'  => 'Kirby Panel (Server)',
            'email' => 'panel@u1.cz'
        ]
    ],
    'hooks' => [
        'file.update:after' => function ($newFile, $oldFile) {
            $parent = $newFile->parent();
            $isProject = $parent instanceof Kirby\Cms\Page && ($parent->intendedTemplate()->name() === 'project' || ($parent->parent() && $parent->parent()->slug() === 'projects'));
            if ($isProject) {
                $images = $parent->images()->filter(function ($img) {
                    return $img->template() !== 'logo' && $img->extension() !== 'svg';
                });
                $imageIndustries = $images->pluck('industry', ',', true);
                $imageSpaces     = $images->pluck('space', ',', true);

                $projectIndustries = $parent->industry()->split(',');
                $projectSpaces     = $parent->space()->split(',');

                $mergedIndustries = array_values(array_unique(array_filter(array_merge($projectIndustries, $imageIndustries))));
                $mergedSpaces     = array_values(array_unique(array_filter(array_merge($projectSpaces, $imageSpaces))));

                $newIndustry = implode(', ', $mergedIndustries);
                $newSpace    = implode(', ', $mergedSpaces);

                if ($newIndustry !== $parent->industry()->value() || $newSpace !== $parent->space()->value()) {
                    kirby()->impersonate('kirby');
                    $parent->update([
                        'industry' => $newIndustry,
                        'space'    => $newSpace,
                    ]);
                }
            }
        },
        'file.create:after' => function ($file) {
            $parent = $file->parent();
            $isProject = $parent instanceof Kirby\Cms\Page && ($parent->intendedTemplate()->name() === 'project' || ($parent->parent() && $parent->parent()->slug() === 'projects'));
            if ($isProject) {
                $images = $parent->images()->filter(function ($img) {
                    return $img->template() !== 'logo' && $img->extension() !== 'svg';
                });
                $imageIndustries = $images->pluck('industry', ',', true);
                $imageSpaces     = $images->pluck('space', ',', true);

                $projectIndustries = $parent->industry()->split(',');
                $projectSpaces     = $parent->space()->split(',');

                $mergedIndustries = array_values(array_unique(array_filter(array_merge($projectIndustries, $imageIndustries))));
                $mergedSpaces     = array_values(array_unique(array_filter(array_merge($projectSpaces, $imageSpaces))));

                $newIndustry = implode(', ', $mergedIndustries);
                $newSpace    = implode(', ', $mergedSpaces);

                if ($newIndustry !== $parent->industry()->value() || $newSpace !== $parent->space()->value()) {
                    kirby()->impersonate('kirby');
                    $parent->update([
                        'industry' => $newIndustry,
                        'space'    => $newSpace,
                    ]);
                }
            }
        },
    ],
    'routes' => function ($kirby) {
      return [
          [
              'pattern' => ['booking/(:any)/(:any)'],
              'action' => function ($collection,$id) {
                $host = explode('.',$_SERVER['HTTP_HOST']);
                $test = array_pop($host) == 'test' ? true : false;
                $eq = $test ? ';' : ':';
                return go("booking.json/collection{$eq}{$collection}/id{$eq}{$id}");
              }
          ],
       
      ];
    },
];

