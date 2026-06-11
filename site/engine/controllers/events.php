<?php

return function ($page) {
    $featured = collection('Events')->first();
    return [
        'featured'   => $featured,
    ];
};
