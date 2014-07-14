<?php

// configure your app for the production environment

// Timezone.
date_default_timezone_set('Europe/Paris');

// Twig cache
$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

// Emails.
$app['admin_email'] = '';
$app['site_email'] = '';

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => '',
    'dbname'   => 'jimmyphimmasone',
    'user'     => 'root',
    'password' => '123',
);

// SwiftMailer
// See http://silex.sensiolabs.org/doc/providers/swiftmailer.html
$app['swiftmailer.options'] = array(
    'host' => 'host',
    'port' => '25',
    'username' => 'username',
    'password' => 'password',
    'encryption' => null,
    'auth_mode' => null
);

