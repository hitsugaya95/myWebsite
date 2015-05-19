<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class BlogController
{
    public function quotesAction(Request $request, Application $app)
    {      
    	// $collections = $app['repository.database']->getCollections();
    	// $albums = $app['repository.database']->getAlbums();
    	// $photos = $app['repository.database']->getPhotos();

		return $app['twig']->render('/admin/blog/quotes.html', array(
			// "collections" => count($collections),
			// "albums"      => count($albums),
			// "photos"      => count($photos),
		));
    }

    public function addQuotesAction(Request $request, Application $app)
    {

        return $app['twig']->render('/admin/blog/add_quotes.html', array(
            // 'background'  => $backgrounds[$rand],
            // 'collections' => $collections,
            // 'photos'      => $photos
        ));
    }

    /**
     * Search gif from giphy library by AJAX
     *
     */
    public function searchGiphyAction(Request $request, Application $app)
    {
        if (null === $request->get('search') || '' === $request->get('search')) {
            return $app->json('Search can not be empty', 500);
        }

        $endpoints = sprintf("http://api.giphy.com/v1/gifs/search?q=%s&api_key=dc6zaTOxFJmzC&limit=10", $request->get('search'));
        $datas = json_decode(file_get_contents($endpoints), true);
        
        $gifs = array();
        foreach ($datas['data'] as $gif) {
            $gifs[] = array(
                'iframe' => sprintf('<iframe src="//giphy.com/embed/%s?html5=true" width="150" height="120" frameBorder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>', $gif['id']),
                'id'    => $gif['id'],
            );
        }

        return $app->json($gifs, 200);
    }
}