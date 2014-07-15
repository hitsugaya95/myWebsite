<?php

namespace JimmyPhimmasone\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AlbumsController
{
    public function albumsAction($collectionId, Request $request, Application $app)
    {
        // Get all albums from collection
    	$albums = $app['repository.database']->getAlbumsByCollection($collectionId);

        // Get collection details
        $collection = $app['repository.database']->getCollection($collectionId);

        // Get itinaries details
        $itineraries = $app['repository.itinerary']->getItineraries($collectionId);

		return $app['twig']->render('albums.html', array(
            'albums'     => $albums, 
            'collection' => $collection,
            'itineraries'  => $itineraries,
        ));
    }

    public function photosAction($albumId, Request $request, Application $app)
    {
    	$photos = $app['repository.database']->getPhotosFromAlbum($albumId);
        $album = $app['repository.database']->getAlbum($albumId);

		return $app['twig']->render('photos.html', array(
            'photos' => $photos,
            'album'  => $album
        ));
    }
}