<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {      
    	$collections = $app['repository.database']->getCollections();
    	$albums = $app['repository.database']->getAlbums();
    	$photos = $app['repository.database']->getPhotos();

        $comments = $app['repository.impression']->getNewComments();

		return $app['twig']->render('/admin/index.html', array(
			"collections" => count($collections),
			"albums"      => count($albums),
			"photos"      => count($photos),
            "comments"    => count($comments),
		));
    }
}