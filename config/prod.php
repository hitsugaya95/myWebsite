<?php

// configure your app for the production environment

// Timezone.
date_default_timezone_set('Europe/Paris');

// Twig cache
$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.cache'] = __DIR__.'/../var/cache/twig';

// Emails.
$app['email'] = 'contact@jimmyphimmasone.fr';

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => null,
    'dbname'   => 'jimmyphimmasone',
    'user'     => 'root',
    'password' => '123',
);

// Security
$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'http' => true,
        'users' => array(
            // raw password is foo
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
    ),
);