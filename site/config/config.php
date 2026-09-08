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
    'cache' => [
        'social' => true
    ],
    'panel' => [
        'css' => 'public/assets/css/panel.custom.css'
    ],
    'instagram.token' => 'IGAARfnJ3rbYlBZAFpvSVZAGSGFLTVFMXzFRUm9kdmlQQzZArS2x6dkFQOUVkWDRDbGJSaWVDOEpXbDFQTldfSWoySkJJd29JNEpWREVweWd5RldwQU9HUV94eTdGeVUtRzJ0TDExVnVzZA2NmdnM2S19uMVlEY21kS2NKQVNZAU1VHSQZDZD',
    'linkedin.org_id' => 'urn:li:organization:18790224',
    'linkedin.token' => 'AQXc40XujSnxksulm1icLv1Sx81FOROFq9Id6NnEOuwYHozxRDdBPyPNjz7ogFt3GckHMTueH4wMdw_JPyQYDPdVMr3T-okjrFy7OX5W8skS7W74G-b4J9jJ7bv2460WQJqnCmERIPny_JKoWMGLnl-F9OF53pOtRZDw42vZ73oWnAYzfz47jVJ3ybFlAGJTXagDO1go_I5IuWaXf9uzSN_7oXYIfM3EMsz_n5HgGEWeVk7H-FJSu9rDpbE4zsyBtipGcPgewVNl1exAytVA_IeAMy1uZMsGLKq0GHFC-T9Z_-l2cOoXPe9CFf8EE5mcvEZJdR2oIPnaCXCd_BV7EKVJBTs1-Q',
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

