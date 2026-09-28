<?php

use Kirby\Toolkit\Str;

return function ($page, $kirby, $site) {
    $filterIndustry = get('industry');
    $filterSpace    = get('space');
    $filterGeneric  = get('filter');
    $filterSearch   = trim((string)(get('search') ?? get('q') ?? ''));

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

    $hasTagFilter   = !empty($filterIndustry) || !empty($filterSpace) || !empty($filterGeneric);
    $hasSearch      = !empty($filterSearch);
    $isFiltered     = $hasTagFilter || $hasSearch;
    $filteredImages = null;
    $projects       = $allProjects;

    // Filter projects if search is active
    if ($hasSearch) {
        $projects = $projects->search($filterSearch, 'title|industry|space|architect|location|intro');
    }

    // 3. Filter ONLY images matching the active tag(s) or search on the images themselves
    if ($isFiltered) {
        $filteredImages = $allImages->filter(function ($image) use ($filterIndustry, $filterSpace, $filterGeneric, $filterSearch) {
            $imageIndustries = array_map([Str::class, 'slug'], $image->industry()->split(','));
            $imageSpaces     = array_map([Str::class, 'slug'], $image->space()->split(','));

            // Search filter check on image / parent project
            if (!empty($filterSearch)) {
                $parent = $image->parent();
                $haystack = mb_strtolower(
                    ($parent ? $parent->title()->value() . ' ' . $parent->industry()->value() . ' ' . $parent->space()->value() . ' ' . $parent->location()->value() . ' ' . $parent->architect()->value() . ' ' : '') .
                    $image->caption()->value() . ' ' .
                    $image->industry()->value() . ' ' .
                    $image->space()->value()
                );
                if (!str_contains($haystack, mb_strtolower($filterSearch))) {
                    return false;
                }
            }

            // If industry filter is set, image MUST explicitly have this industry tag
            if (!empty($filterIndustry) && !in_array($filterIndustry, $imageIndustries)) {
                return false;
            }

            // If space filter is set, image MUST explicitly have this space tag
            if (!empty($filterSpace) && !in_array($filterSpace, $imageSpaces)) {
                return false;
            }

            // Generic legacy filter check (e.g. ?filter=tag)
            if (!empty($filterGeneric)) {
                $genericSlugs = array_map([Str::class, 'slug'], explode(',', $filterGeneric));
                $matchesGeneric = false;
                foreach ($genericSlugs as $slug) {
                    if (in_array($slug, $imageIndustries) || in_array($slug, $imageSpaces)) {
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

    return [
        'industries'     => $industries, 
        'spaces'         => $spaces, 
        'filterIndustry' => $filterIndustry,
        'filterSpace'    => $filterSpace,
        'filterGeneric'  => $filterGeneric,
        'filterSearch'   => $filterSearch,
        'isFiltered'     => $isFiltered,
        'projects'       => $projects->paginate(12),
        'images'         => $hasTagFilter ? ($filteredImages ? $filteredImages->paginate(24) : null) : null,
    ];
};