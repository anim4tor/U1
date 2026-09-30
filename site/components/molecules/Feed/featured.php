<?php
echo snippet('molecules/Feed/list', [
    'item' => $feed ?? $item ?? null,
    'type' => 'blog'
]);
