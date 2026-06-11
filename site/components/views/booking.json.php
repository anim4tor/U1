<?php

$html = 'Test';
$html = snippet('templates/ajax/Booking/'.$collection, ['book' => $book ], true);

$json['html'] = $html;
$json['book'] = $book;
$json['id'] = $id;
$json['collection'] = $collection;

echo json_encode($json);