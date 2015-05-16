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
    'host'     => 'localhost',
    'port'     => null,
    'dbname'   => 'jimmyphimmasone',
    'user'     => 'root',
    'password' => '123',
);

// SwiftMailer
$app['swiftmailer.options'] = array(
    'host' => 'smtp.gmail.com',
    'port' => 465,
    'username' => 'test',
    'password' => 'test',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);

// Security
$app['security.firewalls'] = array(
    'admin' => array(
        'pattern' => '^/admin',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
        'logout' => array('logout_path' => '/admin/logout'),
        'users' => array(
            'mimy' => array('ROLE_ADMIN', 'UxDMbcaiQ3eYlliSIhZaiMx3VojNZmhvC8MRI4FJbzU9rharS2vpAVzciIkLnL8fKG7/r9FXl10pAQMXjxfO5g=='),
            'lily'  => array('ROLE_ADMIN', 'enWrHH8O34eomypOPMuCih0AIHUORmP62/JiUBRD0uPHS2slbelhHCoMeHZtnbepRh8SHtIwVw4bc8dU5W0Ayg=='),
        ),
    ),
);