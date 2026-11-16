<?php

use Kirby\Cms\Collection;
use Kirby\Cms\Page;
use Kirby\Http\Remote;
use Kirby\Filesystem\F;
use Kirby\Filesystem\Dir;

return function ($kirby) {
    $mediaCacheDir = $kirby->root('public') . '/media/social';
    Dir::make($mediaCacheDir);

    $storeDir = $kirby->root('store') . '/social';
    Dir::make($storeDir);
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

        // Only attempt to download if explicitly permitted
        if ($attemptDownload && !empty($remoteUrl) && (str_starts_with($remoteUrl, 'http://') || str_starts_with($remoteUrl, 'https://'))) {
            try {
                $response = Remote::get($remoteUrl, ['timeout' => 2]);
                if ($response->code() === 200 && !empty($response->content())) {
                    F::write($filePath, $response->content());
                    return $localUrl;
                }
            } catch (\Throwable $e) {}
        }

        return $remoteUrl;
    };

    $site = $kirby->site();
    $requiredHashtag = trim((string)($site ? $site->instagramHashtag()->value() : ''));
    if (empty($requiredHashtag)) {
        $requiredHashtag = (string)option('instagram.hashtag', 'web');
    }

    $token = trim((string)($site ? $site->instagramToken()->value() : ''));
    $tokenFile = $storeDir . '/instagram_token.txt';
    if (empty($token) && file_exists($tokenFile)) {
        $token = trim((string)@file_get_contents($tokenFile));
    }
    if (empty($token)) {
        $token = trim((string)option('instagram.token', ''));
    }

    $cache = $kirby->cache('social');
    $cachedPosts = $cache->get('instagram.posts.filtered');

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

    if ($cachedPosts === null || empty($cachedPosts)) {
        $fetchedFresh = false;
        if (!empty($token)) {
            $endpoint = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,timestamp,thumbnail_url&limit=50&access_token={$token}";
            try {
                $response = Remote::get($endpoint, ['timeout' => 3]);
                if ($response->code() === 200) {
                    $freshData = $response->json()['data'] ?? [];
                    if (!empty($freshData)) {
                        $cachedPosts = $freshData;
                        $fetchedFresh = true;
                        F::write($igFallbackFile, json_encode($freshData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                        $cache->set('instagram.posts.filtered', $cachedPosts, 43200); // 12 hours
                    }
                }
            } catch (\Throwable $e) {}
        }

        if (!$fetchedFresh) {
            $cachedPosts = $loadFallbackInstagram();
            $cache->set('instagram.posts.filtered', $cachedPosts, 1800);
        }
    }

    $allProcessed = [];
    $filteredProcessed = [];

    foreach ($cachedPosts as $post) {
        $caption = $post['caption'] ?? '';

        preg_match_all('/#(\w+)/u', $caption, $matches);
        $hashtags = $matches[1] ?? [];

        $rawImageUrl = ($post['media_type'] === 'VIDEO' && isset($post['thumbnail_url']))
            ? $post['thumbnail_url']
            : ($post['media_url'] ?? '');

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

        if (!empty($requiredHashtag) && $requiredHashtag !== '*' && strtolower($requiredHashtag) !== 'all') {
            if (in_array(strtolower($requiredHashtag), array_map('strtolower', $hashtags))) {
                $filteredProcessed[] = $postItem;
            }
        } else {
            $filteredProcessed[] = $postItem;
        }
    }

    $selectedPosts = !empty($filteredProcessed) ? $filteredProcessed : $allProcessed;
    $virtualPages = [];

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
