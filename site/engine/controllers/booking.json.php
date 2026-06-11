<?php

return function ($page, $kirby) {
  $collection = param('collection') ?: null;
  $id = param('id') ?: null;
  $book = collection(ucfirst($collection))->findBy('slug', $id);
  $return = [
    'collection' => $collection,
    'id' => $id,
    'book' => $book,
  ];

  return $return;
};