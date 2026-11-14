<?php

Kirby::plugin('yourname/snippet-options', [
    'pageMethods' => [
        'getCurrentAndGlobalSnippets' => function () {
            $options = [];
            $templatesRoot = kirby()->root('snippets') . '/templates';
            
            // 1. Collect Local Page Sections
            $templateName = ucfirst($this->intendedTemplate()->name());
            $pageSectionsFolder = $templatesRoot . '/' . $templateName . '/sections';
            $localSnippets = [];

            if (is_dir($pageSectionsFolder)) {
                $files = array_diff(scandir($pageSectionsFolder), ['.', '..', '.DS_Store']);
                foreach ($files as $file) {
                    // EXCLUSION: Skip index.php, non-php files, AND files starting with an underscore
                    if (str_ends_with($file, '.php') && $file !== 'index.php' && !str_starts_with($file, '_')) {
                        $name = substr($file, 0, -4);
                        
                        $parts = explode('_', $name, 2);
                        $order = (isset($parts[1]) && is_numeric($parts[0])) ? (int)$parts[0] : 999;
                        $cleanLabel = preg_replace('/^\d+_(.*)$/', '$1', $name);

                        $localSnippets[] = [
                            'order' => $order,
                            'text'  => 'Local: ' . ucfirst($cleanLabel),
                            'value' => $name
                        ];
                    }
                }
            }

            // 2. Collect Global Sections (from components/sections and templates/globals)
            $globalSnippets = [];
            $seenValues = [];

            $sectionsFolder = kirby()->root('snippets') . '/sections';
            $legacyGlobalsFolder = $templatesRoot . '/globals';

            $foldersToScan = [];
            if (is_dir($sectionsFolder)) {
                $foldersToScan['sections'] = $sectionsFolder;
            }
            if (is_dir($legacyGlobalsFolder)) {
                $foldersToScan['global'] = $legacyGlobalsFolder;
            }

            foreach ($foldersToScan as $prefix => $baseFolder) {
                $subfolders = array_diff(scandir($baseFolder), ['.', '..', '.DS_Store']);
                foreach ($subfolders as $sub) {
                    if (str_starts_with($sub, '_')) {
                        continue;
                    }

                    $subPath = $baseFolder . '/' . $sub;
                    if (!is_dir($subPath)) {
                        continue;
                    }

                    $cleanSub = preg_replace('/^\d+_(.*)$/', '$1', $sub);
                    $displayFolder = (strcasecmp($cleanSub, 'FAQs') === 0 || strcasecmp($cleanSub, 'FAQ') === 0) ? 'FAQ' : ucfirst($cleanSub);

                    $files = array_diff(scandir($subPath), ['.', '..', '.DS_Store']);
                    foreach ($files as $file) {
                        if (!str_ends_with($file, '.php') || str_starts_with($file, '_')) {
                            continue;
                        }

                        $fileName = substr($file, 0, -4);
                        
                        $val = ($prefix === 'sections') ? 'sections/' . $sub . '/' . $fileName : 'global/' . $sub . '/' . $fileName;

                        $canonicalVal = $val;
                        if (strcasecmp($sub, 'FAQs') === 0) {
                            $canonicalVal = ($prefix === 'sections') ? 'sections/FAQ/' . $fileName : 'global/FAQ/' . $fileName;
                        }

                        if (isset($seenValues[$canonicalVal])) {
                            continue;
                        }
                        $seenValues[$canonicalVal] = true;

                        $label = 'Global: ' . $displayFolder . '/' . $fileName;
                        $sortKey = strtolower($displayFolder) . '_' . ($fileName === 'index' ? '00_index' : $fileName);

                        $globalSnippets[] = [
                            'sortKey' => $sortKey,
                            'text'    => $label,
                            'value'   => $canonicalVal
                        ];

                        if (strcasecmp($sub, 'FAQs') === 0 && !isset($seenValues[$val])) {
                            $seenValues[$val] = true;
                            $globalSnippets[] = [
                                'sortKey' => strtolower($displayFolder) . '_99_faqs_' . $fileName,
                                'text'    => 'Global: FAQs/' . $fileName,
                                'value'   => $val
                            ];
                        }
                    }
                }
            }

            // 3. Sort structural arrays
            usort($localSnippets, fn($a, $b) => $a['order'] <=> $b['order']);
            usort($globalSnippets, fn($a, $b) => strcmp($a['sortKey'], $b['sortKey']));

            // 4. Merge stacks sequentially
            $merged = array_merge($localSnippets, $globalSnippets);

            return array_map(fn($item) => [
                'text'  => $item['text'],
                'value' => $item['value']
            ], $merged);
        },
        'resolvedCta' => function (string $type = 'contact') {
            // 1. Check if current page has CTA defined
            if ($this->cta()->isNotEmpty()) {
                // For subpages with ctaOverride toggle: only use if override is true
                if (!$this->ctaOverride()->exists() || $this->ctaOverride()->toBool()) {
                    return $this->cta();
                }
            }

            // 2. Walk up parent pages
            foreach ($this->parents() as $parent) {
                if ($parent->cta()->isNotEmpty()) {
                    return $parent->cta();
                }
            }

            // 3. Fallback to site global CTA
            $site = $this->site();
            if ($type === 'career') {
                if ($site->ctaCareer()->isNotEmpty()) {
                    return $site->ctaCareer();
                }
            }
            return $site->ctaContact();
        }
    ]
]);