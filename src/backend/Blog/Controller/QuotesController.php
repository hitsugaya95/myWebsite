<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class QuotesController
{
    public function indexAction(Request $request, Application $app)
    {

		return $app['twig']->render('blog/quotes.html', array(
			// 'background'  => $backgrounds[$rand],
			// 'collections' => $collections,
			// 'photos'      => $photos
		));
    }
}