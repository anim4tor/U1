<?php

use Kirby\Cms\Collection;
use Kirby\Cms\Page;
use Kirby\Http\Remote;
use Kirby\Filesystem\F;
use Kirby\Filesystem\Dir;

return function ($kirby) {
    // 1. Define the hashtag you want to filter by (without '#')
    $requiredHashtag = 'web';

    $mediaCacheDir = $kirby->root('public') . '/media/social';
    Dir::make($mediaCacheDir);

    $getLocalMediaUrl = function ($remoteUrl, $filenamePrefix) use ($mediaCacheDir) {
        if (empty($remoteUrl)) {
            return '';
        }

        $filename = $filenamePrefix . '.jpg';
        $filePath = $mediaCacheDir . '/' . $filename;
        $localUrl = url('public/media/social/' . $filename);

        // If already downloaded and valid, return local URL
        if (file_exists($filePath) && filesize($filePath) > 0) {
            return $localUrl;
        }

        // Otherwise download and save locally
        try {
            $response = Remote::get($remoteUrl, ['timeout' => 8]);
            if ($response->code() === 200 && !empty($response->content())) {
                F::write($filePath, $response->content());
                return $localUrl;
            }
        } catch (\Throwable $e) {
            // Fallback to remote URL on download error
        }

        return $remoteUrl;
    };

    $cache = $kirby->cache('social');
    $cachedPosts = $cache->get('instagram.posts.filtered');

    if ($cachedPosts === null) {
        $token = option('instagram.token');
        if ($token) {
            $endpoint = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,timestamp,thumbnail_url&limit=50&access_token={$token}";
            try {
                $response = Remote::get($endpoint, ['timeout' => 3]);
                if ($response->code() === 200) {
                    $cachedPosts = $response->json()['data'] ?? [];
                    $cache->set('instagram.posts.filtered', $cachedPosts, 43200); // 12 hours
                }
            } catch (\Throwable $e) {
                // Ignore network errors, fall back to empty array
            }
        }

        if ($cachedPosts === null) {
            $cachedPosts = [];
            $cache->set('instagram.posts.filtered', [], 300); // 5 min retry cooldown
        }
    }

    $virtualPages = [];
    foreach ($cachedPosts as $post) {
        $caption = $post['caption'] ?? '';

        // Extract hashtags
        preg_match_all('/#(\w+)/u', $caption, $matches);
        $hashtags = $matches[1] ?? [];

        // FILTER: Skip post if it doesn't contain the required hashtag (case-insensitive)
        $hasTag = in_array(strtolower($requiredHashtag), array_map('strtolower', $hashtags));
        if (!$hasTag) {
            continue;
        }

        $rawImageUrl = ($post['media_type'] === 'VIDEO' && isset($post['thumbnail_url']))
            ? $post['thumbnail_url']
            : ($post['media_url'] ?? '');

        $imageUrl = $getLocalMediaUrl($rawImageUrl, 'instagram-' . $post['id']);

        $content = [
            'uuid'       => 'social-ig-' . $post['id'],
            'title'      => $cleanTitle,
            'media_url'  => $imageUrl,
            'social_url' => $post['permalink'] ?? '',
            'media_type' => $post['media_type'] ?? 'IMAGE',
            'hashtags'   => implode(', ', $hashtags)
        ];

        $virtualPages[] = new Page([
            'slug'         => 'instagram-' . $post['id'],
            'template'     => 'instagram-item',
            'num'          => null,
            'content'      => $content,
            'translations' => [
                'cz' => [
                    'code'    => 'cz',
                    'content' => $content
                ],
                'en' => [
                    'code'    => 'en',
                    'content' => $content
                ]
            ]
        ]);
    }

    return new Collection($virtualPages);
};