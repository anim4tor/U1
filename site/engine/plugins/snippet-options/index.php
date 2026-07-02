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

            // 2. Collect Global Sections
            $globalsFolder = $templatesRoot . '/globals';
            $globalSnippets = [];
            $trailingSnippets = [];

            if (is_dir($globalsFolder)) {
                $subfolders = array_diff(scandir($globalsFolder), ['.', '..', '.DS_Store']);
                foreach ($subfolders as $sub) {
                    // EXCLUSION: Skip global subfolders starting with an underscore
                    if (str_starts_with($sub, '_')) {
                        continue;
                    }

                    $subPath = $globalsFolder . '/' . $sub;
                    
                    if (is_dir($subPath) && file_exists($subPath . '/index.php')) {
                        $parts = explode('_', $sub, 2);
                        $order = (isset($parts[1]) && is_numeric($parts[0])) ? (int)$parts[0] : 999;
                        
                        $cleanName = isset($parts[1]) ? strtolower($parts[1]) : strtolower($sub);
                        $cleanLabel = preg_replace('/^\d+_(.*)$/', '$1', $sub);

                        $snippetData = [
                            'order' => $order,
                            'text'  => 'Global: ' . ucfirst($cleanLabel),
                            'value' => 'global/' . $sub . '/index'
                        ];

                        if (in_array($cleanName, ['feed', 'cta'])) {
                            $trailingSnippets[] = $snippetData;
                        } else {
                            $globalSnippets[] = $snippetData;
                        }
                    }
                }
            }

            // 3. Sort structural arrays independently
            usort($localSnippets, fn($a, $b) => $a['order'] <=> $b['order']);
            usort($globalSnippets, fn($a, $b) => $a['order'] <=> $b['order']);

            // 4. Merge stacks sequentially
            $merged = array_merge($localSnippets, $globalSnippets, $trailingSnippets);

            return array_map(fn($item) => [
                'text'  => $item['text'],
                'value' => $item['value']
            ], $merged);
        }
    ]
]);