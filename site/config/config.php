<?php

return [
    'debug'  => true,
    'panel.install' => true,
    'home' => 'home',
    'languages' => true,
    'colors' => [
        '#f4ee32' => 'neon',
        '#ddf432' => 'lime',
        '#f4cd32' => 'yellow',
        '#f49a32' => 'orange',
        '#db6b57' => 'red',
        '#db5f7e' => 'crimson',
        '#d56ff7' => 'pink',
        '#986ff7' => 'purple',
        '#034dbc' => 'blue',
        '#b3bae7' => 'violet',
        '#afbec8' => 'grey',
        '#7fc2db' => 'marine',
        '#11b5bb' => 'cyan',
    ],
    'panel' => [
        'css' => 'public/assets/css/panel.custom.css'
    ],
    'routes' => function ($kirby) {
      return [
          [
              'pattern' => ['booking/(:any)/(:any)'],
              'action' => function ($collection,$id) {
                $host = explode('.',$_SERVER['HTTP_HOST']);
                $test = array_pop($host) == 'test' ? true : false;
                $eq = $test ? ';' : ':';
                return go("booking.json/collection{$eq}{$collection}/id{$eq}{$id}");
              }
          ],
       
      ];
    },
];

