<?php

return function ($page, $kirby, $site) {
    $minCount = 8; // The minimum number of projects you must get
    $allOtherProjects = collection('Projects')->not($page);

    // 1. Get the current page's tags
    $currentTags = array_map('strtolower', array_merge(
        $page->space()->split(','),
        $page->industry()->split(',')
    ));

    // Initialize an empty collection to accumulate our results
    $similarProjects = new Kirby\Cms\Pages();

    // --- STEP 2: Find projects sharing 2 or more tags ---
    $matchTwoOrMore = $allOtherProjects->filter(function($project) use ($currentTags) {
        $projectTags = array_map('strtolower', array_merge(
            $project->space()->split(','),
            $project->industry()->split(',')
        ));
        return count(array_intersect($currentTags, $projectTags)) >= 2;
    });
    
    // Add them to our collection
    $similarProjects = $similarProjects->add($matchTwoOrMore);

    // --- STEP 3: Fill up to minCount with 1-tag matches if needed ---
    if ($similarProjects->count() < $minCount) {
        $matchOne = $allOtherProjects
            ->not($similarProjects) // Avoid adding duplicates already in our list
            ->filter(function($project) use ($currentTags) {
                $projectTags = array_map('strtolower', array_merge(
                    $project->space()->split(','),
                    $project->industry()->split(',')
                ));
                return count(array_intersect($currentTags, $projectTags)) === 1;
            });
            
        $similarProjects = $similarProjects->add($matchOne);
    }

    // --- STEP 4: Fill any remaining empty slots with the latest listed projects ---
    if ($similarProjects->count() < $minCount) {
        $remainingCount = $minCount - $similarProjects->count();
        $fallbackProjects = $allOtherProjects
            ->not($similarProjects) // Avoid duplicates
            ->listed()
            ->limit($remainingCount);

        $similarProjects = $similarProjects->add($fallbackProjects);
    }

    // 1. Handle password submission (POST)
    if ($kirby->request()->is('POST') && $password = get('secret_password')) {
        if ($password === $page->password()->value()) {
            // Set the temporary flag
            $kirby->session()->set('unlocked_' . $page->id(), true);
            go($page->url());
        } else {
            $kirby->session()->set('unlock_error_' . $page->id(), 'Incorrect password.');
            go($page->url());
        }
    }

    // 2. Read the error message if it exists, then instantly delete it
    $error = $kirby->session()->get('unlock_error_' . $page->id());
    if ($error) {
        $kirby->session()->remove('unlock_error_' . $page->id());
    }

    // 3. Read the unlock status
    $extras = $kirby->session()->get('unlocked_' . $page->id()) === true;

    // --- KEY CHANGE: Clear the access flag immediately ---
    // This ensures that the NEXT reload will find this empty and lock the page.
    if ($extras === true) {
        $kirby->session()->remove('unlocked_' . $page->id());
    }

    return [
        // Ensure we only return exactly the requested count
        'similarProjects' => $similarProjects->limit($minCount),
        'extras'          => $extras,
        'unlockError'     => $error
    ];
};
