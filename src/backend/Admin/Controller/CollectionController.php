<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class CollectionController
{
    public function collectionsAction(Request $request, Application $app)
    {
    	$collections = $app['repository.database']->getCollections();
		return $app['twig']->render('/admin/collections.html', array("collections" => $collections));
    }

    public function albumsAction($collectionId, Request $request, Application $app)
    {
        $albums = $app['repository.database']->getAlbumsByCollection($collectionId);
        $collection = $app['repository.database']->getCollection($collectionId);

        return $app['twig']->render('/admin/albums.html', array("albums" => $albums, "collection" => $collection));
    }

    public function collectionAction($collectionId, Request $request, Application $app)
    {
    	$collection = $app['repository.database']->getCollection($collectionId);

		return $app['twig']->render('/admin/collection.html', array("collection" => $collection));
    }

    public function updateCollectionAction($collectionId, Request $request, Application $app)
    {
    	$params = array(
    		'title' => $request->get('title'),
    		'description' => $request->get('description'),
    	);
    	$update = $app['repository.database']->updateSqlCollection($collectionId, $params);

    	return $app->redirect(sprintf('/admin/collections/%s/', $collectionId));
    }
}