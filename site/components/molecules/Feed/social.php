<?php
/**
 * Feed Social Snippet - forwards to unified list snippet
 */
echo snippet('molecules/Feed/list', [
    'item' => $post ?? $item ?? null,
    'type' => 'social'
]);