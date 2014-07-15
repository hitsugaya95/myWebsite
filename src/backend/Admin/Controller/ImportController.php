<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ImportController
{
    public function collectionsAction(Request $request, Application $app)
    {
    	$import = $app['repository.import']->importCollections();

		return $app['twig']->render('/admin/import_collections.html', array("import" => $import));
    }

    public function albumsAction(Request $request, Application $app)
    {
        $import = $app['repository.import']->importAlbums();

		return $app['twig']->render('/admin/import_albums.html', array("import" => $import));
    }

    public function photosAction(Request $request, Application $app)
    {
        $import = $app['repository.import']->importPhotos();

        return $app['twig']->render('/admin/import_photos.html', array("import" => $import));
    }
}