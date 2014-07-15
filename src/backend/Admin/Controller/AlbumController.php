<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AlbumController
{
    public function albumsAction(Request $request, Application $app)
    {
    	$albums = $app['repository.database']->getAlbums();
		return $app['twig']->render('/admin/albums.html', array("albums" => $albums));
    }

    public function photosAction($albumId, Request $request, Application $app)
    {
        $photos = $app['repository.database']->getPhotosFromAlbum($albumId);
        $album = $app['repository.database']->getAlbum($albumId);

        return $app['twig']->render('/admin/photos.html', array("photos" => $photos, "album" => $album));
    }

    public function albumAction($albumId, Request $request, Application $app)
    {
    	$album = $app['repository.database']->getAlbum($albumId);

		return $app['twig']->render('/admin/album.html', array("album" => $album));
    }

    public function updateAlbumAction($albumId, Request $request, Application $app)
    {
    	$params = array(
    		'title' => $request->get('title'),
    		'description' => $request->get('description'),
    	);

    	$update = $app['repository.database']->updateSqlAlbum($albumId, $params);

    	return $app->redirect(sprintf('/admin/albums/%s/', $albumId));
    }
}