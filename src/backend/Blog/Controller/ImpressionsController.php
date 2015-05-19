<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ImpressionsController
{
    public function indexAction(Request $request, Application $app)
    {

		return $app['twig']->render('blog/impressions.html', array(
			// 'background'  => $backgrounds[$rand],
			// 'collections' => $collections,
			// 'photos'      => $photos
		));
    }

    public function impressionAction($impressionId, Request $request, Application $app)
    {
		return $app['twig']->render('blog/impression.html', array(
			// 'background'  => $backgrounds[$rand],
			// 'collections' => $collections,
			// 'photos'      => $photos
		));
    }
}