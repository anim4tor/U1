<?php

$html = '';
$html = snippet('templates/ajax/Project', ['project' => $project ], true);

$json['html'] = $html;

echo json_encode($json);