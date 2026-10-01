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
        'pages' => [
            'active' => false,
            'type'   => 'file',
            'ignore' => function ($page) {
                return true;
            }
        ],
        'social' => true
    ],
    'panel' => [
        'css' => 'public/assets/css/panel.custom.css'
    ],
    'instagram.token' => 'IGAARfnJ3rbYlBZAFpvSVZAGSGFLTVFMXzFRUm9kdmlQQzZArS2x6dkFQOUVkWDRDbGJSaWVDOEpXbDFQTldfSWoySkJJd29JNEpWREVweWd5RldwQU9HUV94eTdGeVUtRzJ0TDExVnVzZA2NmdnM2S19uMVlEY21kS2NKQVNZAU1VHSQZDZD',
    'linkedin.org_id' => 'urn:li:organization:18790224',
    'linkedin.token' => 'AQVpka3Ei6QC9lPfNKFV7-p8yoTpCkXZuHz8sAhn002y7QKqK5MJo92OJhjvlw57dtxyfJFNZOf3e-A1n__OjBZZVUvlwtMDUmuABUv1s_D3tWTOXOLok68uVeBbWVQL6AyX6NHnWDB9_lHq9yEbPNfjZgxF9a0kzfoqBgn2Oy1Nw7Vf2wNJS9cxWjrM-iEGNb8baTIWNMexMSCqNagDo0zY6OvedKmPcYkQmDXnXdV09kWel7LjWS2eMXRy3j9k8_rOwF0r881Utv7dxk1i6nDXd8g__YBlbj9ww1VI80sojS8jVRVNKalhXyNvYTOLFjbtXIigc10sN6VjS2lM1l_IZaZL3Q',
    'u1.branch-switcher' => [
        'enabled' => false
    ],
    'u1.git-content' => [
        'enabled'  => true,
        'repo'     => 'anim4tor/U1',
        'token'    => getenv('GITHUB_TOKEN') ?: (file_exists(dirname(__DIR__, 2) . '/.env') ? (@parse_ini_file(dirname(__DIR__, 2) . '/.env')['GITHUB_TOKEN'] ?? null) : null) ?: '',
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
              'pattern' => 'theme/save',
              'method' => 'POST',
              'action' => function () {
                $kirby = kirby();
                $generatorScript = $kirby->root('site') . '/components/atoms/Theme/save-theme.php';
                if (file_exists($generatorScript)) {
                    include($generatorScript);
                }
                return \Kirby\Http\Response::json(['status' => 'success', 'message' => 'Theme tokens saved successfully']);
              }
          ],
          [
              'pattern' => 'theme/sync-fonts',
              'method' => 'POST',
              'action' => function () {
                $kirby = kirby();
                $generatorScript = $kirby->root('site') . '/components/atoms/Theme/generate-fonts.php';
                if (file_exists($generatorScript)) {
                    ob_start();
                    include($generatorScript);
                    ob_end_clean();
                }
                return \Kirby\Http\Response::json(['status' => 'success', 'message' => 'Fonts synced successfully']);
              }
          ],
          [
              'pattern' => ['booking/(:any)/(:any)'],
              'action' => function ($collection,$id) {
                $host = explode('.',$_SERVER['HTTP_HOST']);
                $test = array_pop($host) == 'test' ? true : false;
                $eq = $test ? ';' : ':';
                return go("booking.json/collection{$eq}{$collection}/id{$eq}{$id}");
              }
          ],
          [
              'pattern' => ['ajax/projects/search', 'projects/search.json'],
              'action'  => function () {
                $q = trim((string)(get('q') ?? get('search') ?? ''));
                $allProjects = collection('Projects');
                $allImages = $allProjects->images()->filter(function ($f) {
                    return $f->template() !== 'logo' && $f->extension() !== 'svg';
                });

                $formatCount = function ($cnt) {
                    if ($cnt === 1) return '1 fotografie';
                    if ($cnt >= 2 && $cnt <= 4) return $cnt . ' fotografie';
                    return $cnt . ' fotografií';
                };

                $tagMap = [];

                $registerTag = function ($type, $category, $param, $rawText, $image = null) use (&$tagMap) {
                    $trimmed = trim((string)$rawText);
                    if ($trimmed === '') return;
                    $slug = \Kirby\Toolkit\Str::slug($trimmed);
                    if ($slug === '') return;

                    $key = $type . ':' . $slug;
                    if (!isset($tagMap[$key])) {
                        $tagMap[$key] = [
                            'id'       => $key,
                            'title'    => $trimmed,
                            'slug'     => $slug,
                            'type'     => $type,
                            'category' => $category,
                            'param'    => $param,
                            'count'    => 0,
                            'cover'    => null,
                            'url'      => url('projects') . '?' . $param . '=' . $slug
                        ];
                    }

                    if ($image) {
                        $tagMap[$key]['count']++;
                        if (!$tagMap[$key]['cover']) {
                            try {
                                $tagMap[$key]['cover'] = $image->resize(120, 90, 80)->url();
                            } catch (\Throwable $e) {
                                $tagMap[$key]['cover'] = $image->url();
                            }
                        }
                    }
                };

                // Scan all project photos
                foreach ($allImages as $img) {
                    foreach ($img->space()->split(',') as $s) {
                        $registerTag('space', 'Typ prostoru', 'space', $s, $img);
                    }
                    foreach ($img->industry()->split(',') as $i) {
                        $registerTag('industry', 'Odvětví', 'industry', $i, $img);
                    }
                    foreach ($img->tags()->split(',') as $t) {
                        $registerTag('tag', 'Tag', 'filter', $t, $img);
                    }
                }

                // Also scan project level tags
                foreach ($allProjects as $proj) {
                    foreach ($proj->space()->split(',') as $s) {
                        $registerTag('space', 'Typ prostoru', 'space', $s, null);
                    }
                    foreach ($proj->industry()->split(',') as $i) {
                        $registerTag('industry', 'Odvětví', 'industry', $i, null);
                    }
                }

                // For tags without images directly attached yet, calculate matching images from project
                foreach ($tagMap as $key => &$tag) {
                    if ($tag['count'] === 0) {
                        $param = $tag['param'];
                        $slug = $tag['slug'];
                        $matchingImgs = $allImages->filter(function ($img) use ($param, $slug) {
                            $parent = $img->parent();
                            if ($parent) {
                                $projTags = array_map([\Kirby\Toolkit\Str::class, 'slug'], $parent->$param()->split(','));
                                if (in_array($slug, $projTags)) return true;
                            }
                            return false;
                        });
                        $tag['count'] = $matchingImgs->count();
                        if ($matchingImgs->first()) {
                            try {
                                $tag['cover'] = $matchingImgs->first()->resize(120, 90, 80)->url();
                            } catch (\Throwable $e) {
                                $tag['cover'] = $matchingImgs->first()->url();
                            }
                        }
                    }
                    $tag['count_label'] = $formatCount($tag['count']);
                }
                unset($tag);

                $results = array_values($tagMap);

                // Filter by query
                if ($q !== '') {
                    $qSlug = \Kirby\Toolkit\Str::slug($q);
                    $qLower = mb_strtolower($q);
                    $results = array_filter($results, function ($item) use ($qSlug, $qLower) {
                        $titleLower = mb_strtolower($item['title']);
                        return str_contains($titleLower, $qLower) 
                            || str_contains($item['slug'], $qSlug)
                            || str_contains(mb_strtolower($item['category']), $qLower);
                    });
                }

                // Sort by count descending
                usort($results, function ($a, $b) {
                    return $b['count'] <=> $a['count'];
                });

                return \Kirby\Http\Response::json(array_values($results));
              }
          ],
       
      ];
    },
];

