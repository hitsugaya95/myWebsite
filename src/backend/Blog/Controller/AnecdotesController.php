<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AnecdotesController
{
    public function indexAction(Request $request, Application $app)
    {

		return $app['twig']->render('blog/anecdotes.html', array(
			// 'background'  => $backgrounds[$rand],
			// 'collections' => $collections,
			// 'photos'      => $photos
		));
    }
}