<?php

use Kirby\Toolkit\Str;

return function ($page, $kirby, $site) {
    $filterIndustry   = get('industry');
    $filterSpace      = get('space');
    $filterSolution   = get('solution') ?? get('solutions');
    $filterProduction = get('production');
    $filterHash       = get('hash') ?? get('tag');
    $filterYear       = get('year') ?? get('rok');
    $filterGeneric    = get('filter');
    $filterSearch     = trim((string)(get('search') ?? get('q') ?? ''));

    $allProjects = collection('Projects');
    
    // 1. Collect ONLY project photos / gallery / covers — EXCLUDE logos & testimonials
    $allImages = $allProjects->images()->filter(function ($file) {
        return $file->template() !== 'logo' && $file->extension() !== 'svg';
    });
    
    // Helper to merge, clean and deduplicate tags by slug
    $extractTags = function(...$tagArrays) {
        $map = [];
        foreach ($tagArrays as $tags) {
            foreach ($tags as $tag) {
                $trimmed = trim((string)$tag);
                if ($trimmed !== '') {
                    $slug = Str::slug($trimmed);
                    if ($slug !== '' && !isset($map[$slug])) {
                        $map[$slug] = $trimmed;
                    }
                }
            }
        }
        asort($map, SORT_NATURAL | SORT_FLAG_CASE);

        $result = [];
        foreach ($map as $slug => $text) {
            $result[] = [
                'text' => $text,
                'slug' => $slug
            ];
        }
        return $result;
    };

    // Helper to parse parameter into array of slugs
    $parseSlugs = function($val) {
        if (empty($val)) return [];
        if (is_array($val)) {
            $slugs = [];
            foreach ($val as $v) {
                foreach (explode(',', (string)$v) as $sub) {
                    $s = Str::slug(trim($sub));
                    if ($s !== '') $slugs[] = $s;
                }
            }
            return array_values(array_unique($slugs));
        }
        $slugs = [];
        foreach (explode(',', (string)$val) as $sub) {
            $s = Str::slug(trim($sub));
            if ($s !== '') $slugs[] = $s;
        }
        return array_values(array_unique($slugs));
    };

    // 2. Fetch available options from all projects and image tags
    $industries = $extractTags(
        $allProjects->pluck('industry', ',', true),
        $allImages->pluck('industry', ',', true)
    );

    $spaces = $extractTags(
        $allProjects->pluck('space', ',', true),
        $allImages->pluck('space', ',', true)
    );

    $solutions = $extractTags(
        $allProjects->pluck('solutions', ',', true)
    );

    $productions = $extractTags(
        $allProjects->pluck('production', ',', true)
    );

    $hashes = $extractTags(
        $allProjects->pluck('hash', ',', true),
        $allImages->pluck('tags', ',', true)
    );

    // Safe year extractor helper
    $getYear = function($p) {
        if (!$p) return null;
        try {
            $f = $p->date();
            if (!$f || !$f->isNotEmpty()) return null;
            $raw = trim((string)$f->value());
            if (preg_match('/^(\d{4})/', $raw, $m)) {
                return $m[1];
            }
            $y = $f->toDate('Y');
            return $y ? (string)$y : null;
        } catch (\Throwable $e) {
            return null;
        }
    };

    // Extract years from project dates
    $yearMap = [];
    foreach ($allProjects as $proj) {
        $y = $getYear($proj);
        if ($y) $yearMap[$y] = $y;
    }
    krsort($yearMap, SORT_NUMERIC);
    $years = [];
    foreach ($yearMap as $y => $val) {
        $years[] = [
            'text' => (string)$val,
            'slug' => (string)$y
        ];
    }

    $filterIndustrySlugs   = $parseSlugs($filterIndustry);
    $filterSpaceSlugs      = $parseSlugs($filterSpace);
    $filterSolutionSlugs   = $parseSlugs($filterSolution);
    $filterProductionSlugs = $parseSlugs($filterProduction);
    $filterHashSlugs       = $parseSlugs($filterHash);
    $filterYearSlugs       = $parseSlugs($filterYear);
    $genericSlugs         = $parseSlugs($filterGeneric);

    $hasTagFilter = !empty($filterIndustrySlugs) || !empty($filterSpaceSlugs) || !empty($filterSolutionSlugs) || !empty($filterProductionSlugs) || !empty($filterHashSlugs) || !empty($filterYearSlugs) || !empty($genericSlugs);
    $hasSearch    = !empty($filterSearch);
    $isFiltered   = $hasTagFilter || $hasSearch;
    $filteredImages = null;
    $projects     = $allProjects;

    // Filter projects if search is active
    if ($hasSearch) {
        $projects = $projects->search($filterSearch, 'title|industry|space|solutions|production|hash|architect|location|intro');
    }

    // Filter projects by year if active
    if (!empty($filterYearSlugs)) {
        $projects = $projects->filter(function($p) use ($filterYearSlugs, $getYear) {
            $y = $getYear($p);
            return $y && in_array((string)$y, $filterYearSlugs);
        });
    }

    // 3. Filter ONLY images matching active tags or search
    if ($isFiltered) {
        $filteredImages = $allImages->filter(function ($image) use (
            $filterIndustrySlugs, $filterSpaceSlugs, $filterSolutionSlugs, $filterProductionSlugs, $filterHashSlugs, $filterYearSlugs, $genericSlugs, $filterSearch, $getYear
        ) {
            $imageIndustries = array_map([Str::class, 'slug'], $image->industry()->split(','));
            $imageSpaces     = array_map([Str::class, 'slug'], $image->space()->split(','));
            $imageTags       = array_map([Str::class, 'slug'], $image->tags()->split(','));

            $parent          = $image->parent();
            $projIndustries  = $parent ? array_map([Str::class, 'slug'], $parent->industry()->split(',')) : [];
            $projSpaces      = $parent ? array_map([Str::class, 'slug'], $parent->space()->split(',')) : [];
            $projSolutions   = $parent ? array_map([Str::class, 'slug'], $parent->solutions()->split(',')) : [];
            $projProductions = $parent ? array_map([Str::class, 'slug'], $parent->production()->split(',')) : [];
            $projHashes      = $parent ? array_map([Str::class, 'slug'], $parent->hash()->split(',')) : [];
            $projYear        = $getYear($parent);

            $allIndustries  = array_unique(array_filter(array_merge($imageIndustries, $projIndustries)));
            $allSpaces      = array_unique(array_filter(array_merge($imageSpaces, $projSpaces)));
            $allSolutions   = array_unique(array_filter($projSolutions));
            $allProductions = array_unique(array_filter($projProductions));
            $allHashes      = array_unique(array_filter(array_merge($imageTags, $projHashes)));

            // Search filter check on image / parent project
            if (!empty($filterSearch)) {
                $haystack = mb_strtolower(
                    ($parent ? $parent->title()->value() . ' ' . $parent->industry()->value() . ' ' . $parent->space()->value() . ' ' . $parent->solutions()->value() . ' ' . $parent->production()->value() . ' ' . $parent->hash()->value() . ' ' . $parent->location()->value() . ' ' . $parent->architect()->value() . ' ' . ($projYear ?? '') . ' ' : '') .
                    $image->caption()->value() . ' ' .
                    $image->industry()->value() . ' ' .
                    $image->space()->value() . ' ' .
                    $image->tags()->value()
                );
                if (!str_contains($haystack, mb_strtolower($filterSearch))) {
                    return false;
                }
            }

            // Industry multiselect
            if (!empty($filterIndustrySlugs) && empty(array_intersect($filterIndustrySlugs, $allIndustries))) {
                return false;
            }

            // Space multiselect
            if (!empty($filterSpaceSlugs) && empty(array_intersect($filterSpaceSlugs, $allSpaces))) {
                return false;
            }

            // Solution multiselect
            if (!empty($filterSolutionSlugs) && empty(array_intersect($filterSolutionSlugs, $allSolutions))) {
                return false;
            }

            // Production multiselect
            if (!empty($filterProductionSlugs) && empty(array_intersect($filterProductionSlugs, $allProductions))) {
                return false;
            }

            // Hash multiselect
            if (!empty($filterHashSlugs) && empty(array_intersect($filterHashSlugs, $allHashes))) {
                return false;
            }

            // Year multiselect
            if (!empty($filterYearSlugs) && (!$projYear || !in_array($projYear, $filterYearSlugs))) {
                return false;
            }

            // Generic legacy filter
            if (!empty($genericSlugs)) {
                $allCombined = array_merge($allIndustries, $allSpaces, $allSolutions, $allProductions, $allHashes);
                if ($projYear) $allCombined[] = $projYear;
                if (empty(array_intersect($genericSlugs, $allCombined))) {
                    return false;
                }
            }

            return true;
        });
    }

    // 4. Build Active Tokens with Individual Remove URLs
    $activeTokens = [];
    $baseUrl = $page ? $page->url() : url('projects');
    $currentQuery = [];
    if (!empty($filterIndustrySlugs))   $currentQuery['industry']   = implode(',', $filterIndustrySlugs);
    if (!empty($filterSpaceSlugs))      $currentQuery['space']      = implode(',', $filterSpaceSlugs);
    if (!empty($filterSolutionSlugs))   $currentQuery['solution']   = implode(',', $filterSolutionSlugs);
    if (!empty($filterProductionSlugs)) $currentQuery['production'] = implode(',', $filterProductionSlugs);
    if (!empty($filterHashSlugs))       $currentQuery['hash']       = implode(',', $filterHashSlugs);
    if (!empty($filterYearSlugs))       $currentQuery['year']       = implode(',', $filterYearSlugs);
    if (!empty($genericSlugs))         $currentQuery['filter']     = implode(',', $genericSlugs);
    if ($filterSearch)                 $currentQuery['search']     = $filterSearch;

    $findLabel = function($items, $val) {
        $slug = Str::slug($val);
        foreach ($items as $it) {
            if (($it['slug'] ?? '') === $slug || ($it['text'] ?? '') === $val) {
                $txt = $it['text'] ?? $it['name'] ?? $val;
                return Str::ucfirst($txt);
            }
        }
        return Str::ucfirst(str_replace(['-', '_'], ' ', $val));
    };

    // Build token helper for multi-slug params
    $buildTokens = function($slugs, $paramName, $optionsList, $prefix = '') use (&$activeTokens, $currentQuery, $baseUrl, $findLabel) {
        foreach ($slugs as $slug) {
            $remaining = array_values(array_diff($slugs, [$slug]));
            $q = $currentQuery;
            if (!empty($remaining)) {
                $q[$paramName] = implode(',', $remaining);
            } else {
                unset($q[$paramName]);
            }
            $lbl = $findLabel($optionsList, $slug);
            $activeTokens[] = [
                'param'     => $paramName,
                'slug'      => $slug,
                'label'     => $prefix . $lbl,
                'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
            ];
        }
    };

    $buildTokens($filterSpaceSlugs, 'space', $spaces);
    $buildTokens($filterIndustrySlugs, 'industry', $industries);
    $buildTokens($filterSolutionSlugs, 'solution', $solutions);
    $buildTokens($filterProductionSlugs, 'production', $productions);
    $buildTokens($filterHashSlugs, 'hash', $hashes, '#');
    $buildTokens($filterYearSlugs, 'year', $years);
    $buildTokens($genericSlugs, 'filter', array_merge($industries, $spaces, $solutions, $productions, $hashes, $years));

    if (!empty($filterSearch)) {
        $q = $currentQuery; unset($q['search']); unset($q['q']);
        $activeTokens[] = [
            'param'     => 'search',
            'slug'      => $filterSearch,
            'label'     => Str::ucfirst($filterSearch),
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }

    return [
        'industries'       => $industries, 
        'spaces'           => $spaces, 
        'solutions'        => $solutions,
        'productions'      => $productions,
        'hashes'           => $hashes,
        'years'            => $years,
        'filterIndustry'   => !empty($filterIndustrySlugs) ? implode(',', $filterIndustrySlugs) : null,
        'filterSpace'      => !empty($filterSpaceSlugs) ? implode(',', $filterSpaceSlugs) : null,
        'filterSolution'   => !empty($filterSolutionSlugs) ? implode(',', $filterSolutionSlugs) : null,
        'filterProduction' => !empty($filterProductionSlugs) ? implode(',', $filterProductionSlugs) : null,
        'filterHash'       => !empty($filterHashSlugs) ? implode(',', $filterHashSlugs) : null,
        'filterYear'       => !empty($filterYearSlugs) ? implode(',', $filterYearSlugs) : null,
        'filterGeneric'    => !empty($genericSlugs) ? implode(',', $genericSlugs) : null,
        'filterSearch'     => $filterSearch,
        'isFiltered'       => $isFiltered,
        'activeTokens'     => $activeTokens,
        'projects'         => $projects->paginate(12),
        'images'           => $isFiltered ? ($filteredImages ? $filteredImages->paginate(24) : null) : null,
    ];
};