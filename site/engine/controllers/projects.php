<?php

use Kirby\Toolkit\Str;

return function ($page, $kirby, $site) {
    $filterBy = get('filter'); // Receives slug values (e.g., 'real-estate')
    $projects = collection('Projects');
    
    // 1. Fetch unique raw text values for industries and spaces separately
    $rawIndustries = $projects->pluck('industry', ',', true);
    $rawSpaces     = $projects->pluck('space', ',', true);

    sort($rawIndustries);
    sort($rawSpaces);

    // 2. Transform industries into an array containing display text and URL slug
    $industries = array_map(function($tag) {
        return [
            'text' => $tag,
            'slug' => Str::slug($tag)
        ];
    }, $rawIndustries);

    // 3. Transform spaces into an array containing display text and URL slug
    $spaces = array_map(function($tag) {
        return [
            'text' => $tag,
            'slug' => Str::slug($tag)
        ];
    }, $rawSpaces);

    // 4. Filter projects by comparing the URL slug against the project data slugs
    if (empty($filterBy) === false) {
        $projects = $projects->filter(function ($project) use ($filterBy) {
            // Split fields and map them directly into URL slugs
            $projectIndustries = array_map([Str::class, 'slug'], $project->industry()->split(','));
            $projectSpaces     = array_map([Str::class, 'slug'], $project->space()->split(','));
            
            // Match if the requested URL slug exists in either field
            // (Uses OR logic; if you need strict matching per category, adjust accordingly)
            return in_array($filterBy, $projectIndustries) || 
                   in_array($filterBy, $projectSpaces);
        });
    }

    return [
        'industries' => $industries, 
        'spaces'     => $spaces, 
        'filterBy'   => $filterBy,
        'projects'   => $projects->paginate(12),
    ];
};