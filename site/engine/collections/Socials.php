<?php

use Kirby\Cms\Collection;
use Kirby\Cms\Page;
use Kirby\Http\Remote;
use Kirby\Filesystem\F;
use Kirby\Filesystem\Dir;

return function ($kirby) {
    $cache = $kirby->cache('social');
    $virtualPages = [];

    // Helper to download and cache social media images locally
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

    // ----------------------------------------------------
    // 1. FETCH & PROCESS LINKEDIN POSTS
    // ----------------------------------------------------
    $cachedLinkedin = $cache->get('social.linkedin.posts');

    if ($cachedLinkedin === null) {
        $orgId = (string) option('linkedin.org_id');
        $token = trim((string) option('linkedin.token'));
        if (!empty($orgId) && !empty($token)) {
            if (!str_starts_with($orgId, 'urn:li:organization:')) {
                $orgId = 'urn:li:organization:' . $orgId;
            }

            $endpoint = "https://api.linkedin.com/rest/posts?author=" . urlencode($orgId) . "&q=author&count=10";

            try {
                $response = Remote::get($endpoint, [
                    'timeout' => 3,
                    'headers' => [
                        'Authorization'             => 'Bearer ' . $token,
                        'LinkedIn-Version'          => '202601',
                        'X-Restli-Protocol-Version'  => '2.0.0'
                    ]
                ]);

                if ($response->code() === 200) {
                    $cachedLinkedin = $response->json()['elements'] ?? [];
                    $cache->set('social.linkedin.posts', $cachedLinkedin, 43200); // 12 hours
                }
            } catch (\Throwable $e) {
                // Ignore network errors
            }
        }

        if ($cachedLinkedin === null) {
            $cachedLinkedin = [];
            $cache->set('social.linkedin.posts', [], 300); // 5 min cooldown
        }
    }

    foreach ($cachedLinkedin as $post) {
        $postId     = $post['id'] ?? '';
        $commentary = $post['commentary'] ?? '';
        $rawMediaUrl = $post['content']['media']['image'] ?? '';
        $mediaUrl   = !empty($rawMediaUrl) ? $getLocalMediaUrl($rawMediaUrl, 'linkedin-' . md5($postId)) : '';
        // Convert timestamp (ms) or date string to Unix timestamp
        $timestamp  = isset($post['createdAt']) ? (int)($post['createdAt'] / 1000) : time();

        $content = [
            'uuid'         => 'social-li-' . md5($postId),
            'title'        => $commentary,
            'social_url'   => 'https://www.linkedin.com/feed/update/' . $postId,
            'media_url'    => $mediaUrl,
            'platform'     => 'linkedin',
            'date'         => date('Y-m-d H:i:s', $timestamp),
            'timestamp'    => $timestamp,
            'hashtags'     => ''
        ];

        $virtualPages[] = new Page([
            'slug'         => 'linkedin-' . md5($postId),
            'template'     => 'social-item',
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

    // ----------------------------------------------------
    // 2. FETCH & PROCESS INSTAGRAM POSTS
    // ----------------------------------------------------
    $requiredHashtag = 'web';
    $cachedInstagram = $cache->get('social.instagram.posts');

    if ($cachedInstagram === null) {
        $token = option('instagram.token');
        if ($token) {
            $endpoint = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,timestamp,thumbnail_url&limit=50&access_token={$token}";

            try {
                $response = Remote::get($endpoint, ['timeout' => 3]);
                if ($response->code() === 200) {
                    $cachedInstagram = $response->json()['data'] ?? [];
                    $cache->set('social.instagram.posts', $cachedInstagram, 43200); // 12 hours
                }
            } catch (\Throwable $e) {
                // Ignore network errors, fall back to empty array
                $cachedInstagram = [];
                $cache->set('social.instagram.posts', [], 300); // 5 min cooldown
            }
        } else {
            $cachedInstagram = [];
        }
    }

    foreach ($cachedInstagram as $post) {
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

        $cleanTitle = trim(preg_replace('/#\w+/u', '', $caption));
        $timestamp  = isset($post['timestamp']) ? strtotime($post['timestamp']) : time();

        $content = [
            'uuid'       => 'social-ig-' . $post['id'],
            'title'      => $cleanTitle,
            'media_url'  => $imageUrl,
            'social_url' => $post['permalink'] ?? '',
            'media_type' => $post['media_type'] ?? 'IMAGE',
            'platform'   => 'instagram',
            'date'       => date('Y-m-d H:i:s', $timestamp),
            'timestamp'  => $timestamp,
            'hashtags'   => implode(', ', $hashtags)
        ];

        $virtualPages[] = new Page([
            'slug'         => 'instagram-' . $post['id'],
            'template'     => 'social-item',
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

    // ----------------------------------------------------
    // 3. SORT UNIFIED COLLECTION BY DATE (DESCENDING)
    // ----------------------------------------------------
    $collection = new Collection($virtualPages);
    
    return $collection->sortBy('timestamp', 'desc');
};