<?php

namespace JimmyPhimmasone\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
    	$backgrounds = array('splash-1.jpg', 'splash-2.jpg', 'splash-3.jpg', 'splash-4.jpg');
    	$rand = array_rand($backgrounds, 1);

    	$collections = $app['repository.database']->getCollections();
    	$photos = $app['repository.database']->getPhotos();

    	shuffle($photos);
    	$photos = array_splice($photos, 0, 18);

		return $app['twig']->render('index.html', array(
			'background'  => $backgrounds[$rand],
			'collections' => $collections,
			'photos'      => $photos
		));
    }
}