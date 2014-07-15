<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PhotoController
{
    public function photosAction(Request $request, Application $app)
    {
    	$photos = $app['repository.database']->getPhotos();
		return $app['twig']->render('/admin/photos.html', array("photos" => $photos));
    }

    public function photoAction($photoId, Request $request, Application $app)
    {
    	$photo = $app['repository.database']->getPhoto($photoId);

		return $app['twig']->render('/admin/photo.html', array("photo" => $photo));
    }

    public function updatePhotoAction($photoId, Request $request, Application $app)
    {
    	$params = array(
    		'is_published' => null !== $request->get('is_published') ? true : false,
    	);

    	$update = $app['repository.database']->updateSqlPhoto($photoId, $params);

    	return $app->redirect(sprintf('/admin/photos/%s/', $photoId));
    }

    public function coverAction($photoId, Request $request, Application $app)
    {
        $update = $app['repository.database']->setCover($photoId);

        return $app->redirect(sprintf('/admin/photos/%s/', $photoId));
    }
}