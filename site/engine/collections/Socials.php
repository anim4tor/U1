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

    // Persistent storage directory for social post snapshots & tokens
    $storeDir = $kirby->root('store') . '/social';
    Dir::make($storeDir);
    $liFallbackFile = $storeDir . '/linkedin.json';
    $igFallbackFile = $storeDir . '/instagram.json';

    $getLocalMediaUrl = function ($remoteUrl, $filenamePrefix, $attemptDownload = false) use ($mediaCacheDir) {
        if (empty($remoteUrl)) {
            return '';
        }

        $filename = $filenamePrefix . '.jpg';
        $filePath = $mediaCacheDir . '/' . $filename;
        $localUrl = url('public/media/social/' . $filename);

        // If already downloaded and valid, return local URL immediately
        if (file_exists($filePath) && filesize($filePath) > 0) {
            return $localUrl;
        }

        // Only attempt HTTP download when explicitly permitted (e.g. on fresh API response)
        if ($attemptDownload && !empty($remoteUrl) && (str_starts_with($remoteUrl, 'http://') || str_starts_with($remoteUrl, 'https://'))) {
            try {
                $imgResponse = Remote::get($remoteUrl, ['timeout' => 2]);
                if ($imgResponse->code() === 200 && !empty($imgResponse->content())) {
                    F::write($filePath, $imgResponse->content());
                    return $localUrl;
                }
            } catch (\Throwable $e) {}
        }

        return $remoteUrl;
    };

    // ----------------------------------------------------
    // 1. FETCH & PROCESS LINKEDIN POSTS
    // ----------------------------------------------------
    $cachedLinkedin = $cache->get('social.linkedin.posts');

    $loadFallbackLinkedin = function () use ($liFallbackFile) {
        if (file_exists($liFallbackFile)) {
            $json = @file_get_contents($liFallbackFile);
            $data = json_decode($json, true);
            if (is_array($data) && !empty($data)) {
                return $data;
            }
        }
        return [];
    };

    if ($cachedLinkedin === null || empty($cachedLinkedin)) {
        $cachedLinkedin = [];
        $orgId = (string) option('linkedin.org_id');
        $token = trim((string) option('linkedin.token'));
        $fetchedFreshLi = false;

        if (!empty($orgId) && !empty($token)) {
            if (!str_starts_with($orgId, 'urn:li:organization:')) {
                $orgId = 'urn:li:organization:' . $orgId;
            }

            $endpoint = "https://api.linkedin.com/rest/posts?author=" . urlencode($orgId) . "&q=author&count=8";

            try {
                $response = Remote::get($endpoint, [
                    'timeout' => 2,
                    'headers' => [
                        'Authorization'             => 'Bearer ' . $token,
                        'LinkedIn-Version'          => '202601',
                        'X-Restli-Protocol-Version' => '2.0.0'
                    ]
                ]);

                if ($response->code() === 200) {
                    $rawPosts = $response->json()['elements'] ?? [];
                    $freshLinkedin = [];

                    foreach ($rawPosts as $post) {
                        $postId     = $post['id'] ?? '';
                        $commentary = $post['commentary'] ?? '';
                        $content    = $post['content'] ?? [];
                        $mediaUrn   = $content['multiImage']['images'][0]['id'] ?? ($content['media']['id'] ?? null);
                        $mediaUrl   = '';

                        if ($mediaUrn) {
                            $mediaCacheKey = 'social.li.urn.' . md5($mediaUrn);
                            $cachedUrnUrl = $cache->get($mediaCacheKey);
                            if ($cachedUrnUrl) {
                                $mediaUrl = $cachedUrnUrl;
                            } else {
                                $apiHeaders = [
                                    'Authorization'            => 'Bearer ' . $token,
                                    'LinkedIn-Version'         => '202601',
                                    'X-Restli-Protocol-Version' => '2.0.0'
                                ];

                                try {
                                    if (str_starts_with($mediaUrn, 'urn:li:image:')) {
                                        $imgRes = Remote::get('https://api.linkedin.com/rest/images/' . urlencode($mediaUrn), [
                                            'timeout' => 2,
                                            'headers' => $apiHeaders
                                        ]);
                                        if ($imgRes->code() === 200) {
                                            $mediaUrl = $imgRes->json()['downloadUrl'] ?? '';
                                        }
                                    } elseif (str_starts_with($mediaUrn, 'urn:li:video:')) {
                                        $vidRes = Remote::get('https://api.linkedin.com/rest/videos/' . urlencode($mediaUrn), [
                                            'timeout' => 2,
                                            'headers' => $apiHeaders
                                        ]);
                                        if ($vidRes->code() === 200) {
                                            $mediaUrl = $vidRes->json()['thumbnail'] ?? '';
                                        }
                                    }
                                    if (!empty($mediaUrl)) {
                                        $cache->set($mediaCacheKey, $mediaUrl, 604800);
                                    }
                                } catch (\Throwable $e) {}
                            }
                        } elseif (!empty($content['article']['thumbnail'])) {
                            $mediaUrl = $content['article']['thumbnail'];
                        }

                        $freshLinkedin[] = [
                            'id'         => $postId,
                            'commentary' => $commentary,
                            'media_url'  => $mediaUrl,
                            'createdAt'  => $post['createdAt'] ?? ($post['publishedAt'] ?? null)
                        ];
                    }

                    if (!empty($freshLinkedin)) {
                        $cachedLinkedin = $freshLinkedin;
                        $fetchedFreshLi = true;
                        F::write($liFallbackFile, json_encode($freshLinkedin, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                        $cache->set('social.linkedin.posts', $cachedLinkedin, 43200); // 12 hours
                    }
                }
            } catch (\Throwable $e) {}
        }

        if (!$fetchedFreshLi) {
            $cachedLinkedin = $loadFallbackLinkedin();
            $cache->set('social.linkedin.posts', $cachedLinkedin, 1800); // 30 min cooldown
        }
    }

    foreach ($cachedLinkedin as $post) {
        $postId      = $post['id'] ?? '';
        $commentary  = $post['commentary'] ?? '';
        $rawMediaUrl = $post['media_url'] ?? '';
        $mediaUrl    = !empty($rawMediaUrl) ? $getLocalMediaUrl($rawMediaUrl, 'linkedin-' . md5($postId)) : '';
        $timestamp   = isset($post['createdAt']) ? (int)($post['createdAt'] / 1000) : time();

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
    $site = $kirby->site();
    $requiredHashtag = trim((string)($site ? $site->instagramHashtag()->value() : ''));
    if (empty($requiredHashtag)) {
        $requiredHashtag = (string)option('instagram.hashtag', 'web');
    }

    // Token priority: 1) Panel site->instagramToken() 2) Stored token file 3) config.php
    $token = trim((string)($site ? $site->instagramToken()->value() : ''));
    $tokenFile = $storeDir . '/instagram_token.txt';
    if (empty($token) && file_exists($tokenFile)) {
        $token = trim((string)@file_get_contents($tokenFile));
    }
    if (empty($token)) {
        $token = trim((string)option('instagram.token', ''));
    }

    $cachedInstagram = $cache->get('social.instagram.posts');

    $loadFallbackInstagram = function () use ($igFallbackFile) {
        if (file_exists($igFallbackFile)) {
            $json = @file_get_contents($igFallbackFile);
            $data = json_decode($json, true);
            if (is_array($data) && !empty($data)) {
                return $data;
            }
        }
        return [];
    };

    if ($cachedInstagram === null || empty($cachedInstagram)) {
        $fetchedFreshIg = false;

        if (!empty($token)) {
            $endpoint = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,timestamp,thumbnail_url&limit=50&access_token={$token}";

            try {
                $response = Remote::get($endpoint, ['timeout' => 3]);
                if ($response->code() === 200) {
                    $freshData = $response->json()['data'] ?? [];
                    if (!empty($freshData)) {
                        $cachedInstagram = $freshData;
                        $fetchedFreshIg = true;

                        // Download fresh images immediately to prevent CDN link expiration
                        foreach ($cachedInstagram as $p) {
                            $rawUrl = ($p['media_type'] === 'VIDEO' && isset($p['thumbnail_url']))
                                ? $p['thumbnail_url']
                                : ($p['media_url'] ?? '');
                            if (!empty($rawUrl)) {
                                $getLocalMediaUrl($rawUrl, 'instagram-' . $p['id'], true);
                            }
                        }

                        // Save snapshot to persistent store
                        F::write($igFallbackFile, json_encode($freshData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                        $cache->set('social.instagram.posts', $cachedInstagram, 43200); // 12 hours

                        // Auto-refresh token if near 25 days
                        $lastRefreshFile = $storeDir . '/instagram_token_refreshed.txt';
                        $lastRefresh = file_exists($lastRefreshFile) ? (int)@file_get_contents($lastRefreshFile) : 0;
                        if (time() - $lastRefresh > (25 * 86400)) {
                            try {
                                $refEndpoint = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token={$token}";
                                $refRes = Remote::get($refEndpoint, ['timeout' => 3]);
                                if ($refRes->code() === 200) {
                                    $refJson = $refRes->json();
                                    if (!empty($refJson['access_token'])) {
                                        F::write($tokenFile, $refJson['access_token']);
                                        F::write($lastRefreshFile, (string)time());
                                    }
                                }
                            } catch (\Throwable $e) {}
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        if (!$fetchedFreshIg) {
            $cachedInstagram = $loadFallbackInstagram();
            // 30 minute cooldown before trying API again
            $cache->set('social.instagram.posts', $cachedInstagram, 1800);
        }
    }

    // Process posts & apply hashtag filtering
    $allProcessed = [];
    $filteredProcessed = [];

    foreach ($cachedInstagram as $post) {
        $caption = $post['caption'] ?? '';

        // Extract hashtags
        preg_match_all('/#(\w+)/u', $caption, $matches);
        $hashtags = $matches[1] ?? [];

        $rawImageUrl = ($post['media_type'] === 'VIDEO' && isset($post['thumbnail_url']))
            ? $post['thumbnail_url']
            : ($post['media_url'] ?? '');

        // Use cached image or local image without blocking HTTP calls
        $imageUrl = $getLocalMediaUrl($rawImageUrl, 'instagram-' . $post['id'], false);

        $cleanTitle = trim(preg_replace('/#\w+/u', '', $caption));
        $timestamp  = isset($post['timestamp']) ? strtotime($post['timestamp']) : time();

        $postItem = [
            'post'       => $post,
            'cleanTitle' => $cleanTitle,
            'imageUrl'   => $imageUrl,
            'timestamp'  => $timestamp,
            'hashtags'   => $hashtags
        ];

        $allProcessed[] = $postItem;

        // Check hashtag filter if active
        if (!empty($requiredHashtag) && $requiredHashtag !== '*' && strtolower($requiredHashtag) !== 'all') {
            if (in_array(strtolower($requiredHashtag), array_map('strtolower', $hashtags))) {
                $filteredProcessed[] = $postItem;
            }
        } else {
            $filteredProcessed[] = $postItem;
        }
    }

    // If hashtag-filtered set has posts, use it; otherwise fallback to all posts
    $selectedPosts = !empty($filteredProcessed) ? $filteredProcessed : $allProcessed;

    foreach ($selectedPosts as $item) {
        $post = $item['post'];

        $content = [
            'uuid'       => 'social-ig-' . $post['id'],
            'title'      => $item['cleanTitle'],
            'media_url'  => $item['imageUrl'],
            'social_url' => $post['permalink'] ?? '',
            'media_type' => $post['media_type'] ?? 'IMAGE',
            'platform'   => 'instagram',
            'date'       => date('Y-m-d H:i:s', $item['timestamp']),
            'timestamp'  => $item['timestamp'],
            'hashtags'   => implode(', ', $item['hashtags'])
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
