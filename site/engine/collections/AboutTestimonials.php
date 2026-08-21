<?php
use Kirby\Cms\Structure;

return function ($site) {
    // Get the about page or fall back to homepage
    $aboutPage = page('about') ?? $site->homePage();

    // Fetch employee subpages with testimonials
    $employees = $aboutPage->children()->listed()->filter(function ($child) {
        return $child->testimonial()->isNotEmpty();
    });

    $data = [];
    foreach ($employees as $employee) {
        $data[] = [
            'testimonialQuote'    => $employee->testimonial()->inline()->value(),
            'testimonialImage'    => $employee->photo()->value(),
            'testimonialAuthor'   => $employee->title()->value(),
            'testimonialPosition' => $employee->role()->value(),
        ];
    }

    // $aboutPage is a valid Kirby Page object
    return Structure::factory($data, ['parent' => $aboutPage]);
};


