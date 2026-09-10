<?php

use Kirby\Toolkit\Str;

return function ($page, $kirby, $site) {
    $filterIndustry = get('industry');
    $filterSpace    = get('space');
    $filterGeneric  = get('filter');

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

    $isFiltered     = !empty($filterIndustry) || !empty($filterSpace) || !empty($filterGeneric);
    $filteredImages = null;
    $projects       = $allProjects;

    // 3. Filter ONLY images matching the active tag(s) on the images themselves (supports two tags simultaneously)
    if ($isFiltered) {
        $filteredImages = $allImages->filter(function ($image) use ($filterIndustry, $filterSpace, $filterGeneric) {
            $imageIndustries = array_map([Str::class, 'slug'], $image->industry()->split(','));
            $imageSpaces     = array_map([Str::class, 'slug'], $image->space()->split(','));

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
        'isFiltered'     => $isFiltered,
        'projects'       => $projects->paginate(12),
        'images'         => $filteredImages ? $filteredImages->paginate(24) : null,
    ];
};