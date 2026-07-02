<?php

use Kirby\Toolkit\Str;

return function ($page, $kirby, $site) {
    $filterBy = get('filter'); // Receives slug values (e.g., 'real-estate')
    $projects = collection('Projects');
    
    // 1. Fetch unique raw text values from your fields
    $industries = $projects->pluck('industry', ',', true);
    $spaces     = $projects->pluck('space', ',', true);

    // 2. Merge and remove duplicates
    $rawTags = array_unique(array_merge($industries, $spaces));
    sort($rawTags);

    // 3. Transform the tags into an array containing BOTH the display text and the URL slug
    $tags = array_map(function($tag) {
        return [
            'text' => $tag,
            'slug' => Str::slug($tag)
        ];
    }, $rawTags);

    // 4. Filter projects by comparing the URL slug against the project data slugs
    if (empty($filterBy) === false) {
        $projects = $projects->filter(function ($project) use ($filterBy) {
            // Split fields and map them directly into URL slugs
            $projectIndustries = array_map([Str::class, 'slug'], $project->industry()->split(','));
            $projectSpaces     = array_map([Str::class, 'slug'], $project->space()->split(','));
            
            // Match if the requested URL slug exists in either field
            return in_array($filterBy, $projectIndustries) || 
                   in_array($filterBy, $projectSpaces);
        });
    }

    return [
        'tags'     => $tags, 
        'filterBy' => $filterBy,
        'projects' => $projects->paginate(12),
    ];
};