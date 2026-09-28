<?php
echo snippet('molecules/Feed/list', [
    'item' => $post ?? $item ?? null,
    'type' => 'social'
]);
