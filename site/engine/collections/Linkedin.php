<?php

use Kirby\Cms\Collection;
use Kirby\Cms\Page;
use Kirby\Http\Remote;

return function ($kirby) {
    $cache = $kirby->cache('social');
    $cachedPosts = $cache->get('linkedin.posts');

    if ($cachedPosts === null) {
        $token  = option('linkedin.token');
        $orgId  = option('linkedin.org_id'); // e.g. 'urn:li:organization:12345678'
        
        if ($token && $orgId) {
            $endpoint = "https://api.linkedin.com/rest/posts?author=" . urlencode($orgId) . "&q=author&count=10";
            
            try {
                $response = Remote::get($endpoint, [
                    'timeout' => 3,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'LinkedIn-Version' => '202401',
                        'X-Restli-Protocol-Version' => '2.0.0'
                    ]
                ]);

                if ($response->code() === 200) {
                    $cachedPosts = $response->json()['elements'] ?? [];
                    $cache->set('linkedin.posts', $cachedPosts, 43200); // 12 hours
                }
            } catch (\Throwable $e) {
                // Ignore network errors
            }
        }

        if ($cachedPosts === null) {
            $cachedPosts = [];
            $cache->set('linkedin.posts', [], 300); // 5 min retry cooldown
        }
    }

    $virtualPages = [];
    foreach ($cachedPosts as $post) {
        $postId = $post['id'] ?? '';
        $commentary = $post['commentary'] ?? ''; // Post text body

        $virtualPages[] = new Page([
            'slug'     => 'linkedin-' . md5($postId),
            'template' => 'linkedin-item',
            'content'  => [
                'title'        => $commentary,
                'social_url' => 'https://www.linkedin.com/feed/update/' . $postId,
                'published_at' => $post['createdAt'] ?? null,
            ]
        ]);
    }

    return new Collection($virtualPages);
};