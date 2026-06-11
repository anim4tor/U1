<?php
define('BASE_PROJECT_PATH', $_SERVER['HTTP_HOST'] !== 'yogaid.cz.test' ? "/projects/yogaid.cz" : "");
require 'kirby/bootstrap.php';
function formatNum($num) {
    return str_pad($num, 2, '0', STR_PAD_LEFT);
}
$_SERVER['SCRIPT_NAME'] = preg_replace('/\/domains\/' . $_SERVER['HTTP_HOST'] . '/', '', $_SERVER['SCRIPT_NAME']);
$local = __DIR__;
// $local = '';
$kirby = new Kirby(
[
    'roots' => [
        // 'index'   => $local . '/index.php',
        // src
        'site'      => $local . '/site',

            // components
            'snippets'  => $local . '/site/components',
                'templates' => $local . '/site/components/views',

            // admin
            'admin'     => $local . '/site/admin',

            // config
            'config'        => $local . '/site/config',
            
            // lib
            'engine'       => $local . '/site/engine',
                'blueprints'    => $local . '/site/engine/blueprints',
                'collections'   => $local . '/site/engine/collections',
                'controllers'    => $local . '/site/engine/controllers',
                'models'        => $local . '/site/engine/models',
                'plugins'       => $local . '/site/engine/plugins',

            // store
            'store'     => $local . '/site/store',
                'cache'         => $local . '/site/store/cache',
                'logs'          => $local . '/site/store/logs',

                // safe
                'safe'      => $local . '/site/store/safe',
                    'accounts'      => $local . '/site/store/safe/accounts',
                    'sessions'      => $local . '/site/store/safe/sessions',


        // public
        'public'      => $local . '/public',
            'content'   => $local . '/public/content',
            'assets'    => $local . '/public/assets',
            'media'     => $local . '/public/media',
    ]
]
);
// echo __DIR__;
echo $kirby->render();
