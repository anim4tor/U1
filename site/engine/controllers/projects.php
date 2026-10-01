<?php

use Kirby\Toolkit\Str;

return function ($page, $kirby, $site) {
    $filterIndustry = get('industry');
    $filterSpace    = get('space');
    $filterSolution   = get('solution') ?? get('solutions');
    $filterProduction = get('production');
    $filterHash       = get('hash') ?? get('tag');
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

    $hasTagFilter = !empty($filterIndustry) || !empty($filterSpace) || !empty($filterSolution) || !empty($filterProduction) || !empty($filterHash) || !empty($filterGeneric);
    $hasSearch    = !empty($filterSearch);
    $isFiltered   = $hasTagFilter || $hasSearch;
    $filteredImages = null;
    $projects     = $allProjects;

    // Filter projects if search is active
    if ($hasSearch) {
        $projects = $projects->search($filterSearch, 'title|industry|space|solutions|production|hash|architect|location|intro');
    }

    // 3. Filter ONLY images matching the active tag(s) or search on the images themselves
    if ($isFiltered) {
        $filterIndustrySlug   = !empty($filterIndustry) ? Str::slug($filterIndustry) : null;
        $filterSpaceSlug      = !empty($filterSpace) ? Str::slug($filterSpace) : null;
        $filterSolutionSlug   = !empty($filterSolution) ? Str::slug($filterSolution) : null;
        $filterProductionSlug = !empty($filterProduction) ? Str::slug($filterProduction) : null;
        $filterHashSlug       = !empty($filterHash) ? Str::slug($filterHash) : null;
        $genericSlugs         = !empty($filterGeneric) ? array_map([Str::class, 'slug'], explode(',', $filterGeneric)) : [];

        $filteredImages = $allImages->filter(function ($image) use (
            $filterIndustrySlug, $filterSpaceSlug, $filterSolutionSlug, $filterProductionSlug, $filterHashSlug, $genericSlugs, $filterSearch
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

            $allIndustries  = array_unique(array_filter(array_merge($imageIndustries, $projIndustries)));
            $allSpaces      = array_unique(array_filter(array_merge($imageSpaces, $projSpaces)));
            $allSolutions   = array_unique(array_filter($projSolutions));
            $allProductions = array_unique(array_filter($projProductions));
            $allHashes      = array_unique(array_filter(array_merge($imageTags, $projHashes)));

            // Search filter check on image / parent project
            if (!empty($filterSearch)) {
                $haystack = mb_strtolower(
                    ($parent ? $parent->title()->value() . ' ' . $parent->industry()->value() . ' ' . $parent->space()->value() . ' ' . $parent->solutions()->value() . ' ' . $parent->production()->value() . ' ' . $parent->hash()->value() . ' ' . $parent->location()->value() . ' ' . $parent->architect()->value() . ' ' : '') .
                    $image->caption()->value() . ' ' .
                    $image->industry()->value() . ' ' .
                    $image->space()->value() . ' ' .
                    $image->tags()->value()
                );
                if (!str_contains($haystack, mb_strtolower($filterSearch))) {
                    return false;
                }
            }

            // Industry filter
            if ($filterIndustrySlug && !in_array($filterIndustrySlug, $allIndustries)) {
                return false;
            }

            // Space filter
            if ($filterSpaceSlug && !in_array($filterSpaceSlug, $allSpaces)) {
                return false;
            }

            // Solution filter
            if ($filterSolutionSlug && !in_array($filterSolutionSlug, $allSolutions)) {
                return false;
            }

            // Production filter
            if ($filterProductionSlug && !in_array($filterProductionSlug, $allProductions)) {
                return false;
            }

            // Hash filter
            if ($filterHashSlug && !in_array($filterHashSlug, $allHashes)) {
                return false;
            }

            // Generic legacy filter check (e.g. ?filter=tag)
            if (!empty($genericSlugs)) {
                $matchesGeneric = false;
                $allCombined = array_merge($allIndustries, $allSpaces, $allSolutions, $allProductions, $allHashes);
                foreach ($genericSlugs as $slug) {
                    if (in_array($slug, $allCombined)) {
                        $matchesGeneric = true;
                        break;
                    }
                }
                if (!$matchesGeneric) {
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
    if ($filterIndustry)   $currentQuery['industry']   = $filterIndustry;
    if ($filterSpace)      $currentQuery['space']      = $filterSpace;
    if ($filterSolution)   $currentQuery['solution']   = $filterSolution;
    if ($filterProduction) $currentQuery['production'] = $filterProduction;
    if ($filterHash)       $currentQuery['hash']       = $filterHash;
    if ($filterGeneric)    $currentQuery['filter']     = $filterGeneric;
    if ($filterSearch)     $currentQuery['search']     = $filterSearch;

    $findLabel = function($items, $val) {
        $slug = Str::slug($val);
        foreach ($items as $it) {
            if (($it['slug'] ?? '') === $slug || ($it['text'] ?? '') === $val) {
                return $it['text'] ?? $it['name'] ?? $val;
            }
        }
        return ucfirst(str_replace(['-', '_'], ' ', $val));
    };

    if (!empty($filterSpace)) {
        $q = $currentQuery; unset($q['space']);
        $activeTokens[] = [
            'param'     => 'space',
            'label'     => $findLabel($spaces, $filterSpace),
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }
    if (!empty($filterIndustry)) {
        $q = $currentQuery; unset($q['industry']);
        $activeTokens[] = [
            'param'     => 'industry',
            'label'     => $findLabel($industries, $filterIndustry),
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }
    if (!empty($filterSolution)) {
        $q = $currentQuery; unset($q['solution']); unset($q['solutions']);
        $activeTokens[] = [
            'param'     => 'solution',
            'label'     => $findLabel($solutions, $filterSolution),
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }
    if (!empty($filterProduction)) {
        $q = $currentQuery; unset($q['production']);
        $activeTokens[] = [
            'param'     => 'production',
            'label'     => $findLabel($productions, $filterProduction),
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }
    if (!empty($filterHash)) {
        $q = $currentQuery; unset($q['hash']); unset($q['tag']);
        $lbl = $findLabel($hashes, $filterHash);
        $activeTokens[] = [
            'param'     => 'hash',
            'label'     => str_starts_with($lbl, '#') ? $lbl : '#' . $lbl,
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }
    if (!empty($filterGeneric)) {
        $q = $currentQuery; unset($q['filter']);
        $allTags = array_merge($industries, $spaces, $solutions, $productions, $hashes);
        $activeTokens[] = [
            'param'     => 'filter',
            'label'     => $findLabel($allTags, $filterGeneric),
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }
    if (!empty($filterSearch)) {
        $q = $currentQuery; unset($q['search']); unset($q['q']);
        $activeTokens[] = [
            'param'     => 'search',
            'label'     => '„' . $filterSearch . '“',
            'removeUrl' => $baseUrl . (!empty($q) ? '?' . http_build_query($q) : '')
        ];
    }

    return [
        'industries'       => $industries, 
        'spaces'           => $spaces, 
        'solutions'        => $solutions,
        'productions'      => $productions,
        'hashes'           => $hashes,
        'filterIndustry'   => $filterIndustry,
        'filterSpace'      => $filterSpace,
        'filterSolution'   => $filterSolution,
        'filterProduction' => $filterProduction,
        'filterHash'       => $filterHash,
        'filterGeneric'    => $filterGeneric,
        'filterSearch'     => $filterSearch,
        'isFiltered'       => $isFiltered,
        'activeTokens'     => $activeTokens,
        'projects'         => $projects->paginate(12),
        'images'           => $isFiltered ? ($filteredImages ? $filteredImages->paginate(24) : null) : null,
    ];
};