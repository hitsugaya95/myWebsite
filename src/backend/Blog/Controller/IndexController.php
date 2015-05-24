<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
        $quote = $app['repository.quote']->getLastQuote();
        $anecdote = $app['repository.anecdote']->getLastAnecdote();

  //   	$collections = $app['repository.database']->getCollections();
  //   	$photos = $app['repository.database']->getPhotos();

  //   	shuffle($photos);
  //   	$photos = array_splice($photos, 0, 18);

		return $app['twig']->render('blog/index.html', array(
			'quote'     => $quote,
            'anecdote'  => $anecdote,
			// 'collections' => $collections,
			// 'photos'      => $photos
		));
    }
}