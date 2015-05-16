<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class BlogController
{
    public function articlesAction(Request $request, Application $app)
    {      
    	// $collections = $app['repository.database']->getCollections();
    	// $albums = $app['repository.database']->getAlbums();
    	// $photos = $app['repository.database']->getPhotos();

		return $app['twig']->render('/admin/blog/articles.html', array(
			// "collections" => count($collections),
			// "albums"      => count($albums),
			// "photos"      => count($photos),
		));
    }
}