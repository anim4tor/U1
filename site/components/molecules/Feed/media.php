<?php
/**
 * Feed Media Snippet - forwards to unified list snippet
 */
echo snippet('molecules/Feed/list', [
    'item' => $feed ?? $item ?? null,
    'type' => 'media'
]);
