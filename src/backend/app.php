<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Provider\SerializerServiceProvider;

// Register service providers.
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app->register(new SerializerServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    $app['db.options'],
));

$app->register(new Silex\Provider\SwiftmailerServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => $app['security.firewalls']
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.cache']) ? $app['twig.cache'] : false,
        'strict_variables' => true,
    ),
    'twig.path' => $app['twig.path']
));

// Register repositories.
$app['repository.contact'] = $app->share(function ($app) {
    return new JimmyPhimmasone\Repository\ContactRepository($app);
});

$app['repository.import'] = $app->share(function ($app) {
    return new Admin\Repository\ImportRepository($app);
});

$app['repository.database'] = $app->share(function ($app) {
    return new Admin\Repository\DatabaseRepository($app);
});

$app['repository.itinerary'] = $app->share(function ($app) {
    return new Admin\Repository\ItineraryRepository($app);
});

$app['service.googlemaps'] = $app->share(function () {
    return new Service\GoogleMaps();
});

$app['service.flickr'] = $app->share(function () {
    return new Service\Flickr();
});

// get User
$app['user'] = $app->share(function ($app) {
    $token = $app['security']->getToken();
    if (null !== $token) {
        $user = $token->getUser();
        return $user->getUsername();
    }

    return null;
});

// Register the error handler.
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

return $app;