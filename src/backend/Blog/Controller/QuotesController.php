<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class QuotesController
{
    public function indexAction(Request $request, Application $app)
    {
    	$actualPage = null !== $request->get('page') ? $request->get('page') : 1;
    	$maxPage = $app['repository.quote']->getQuotesMaxPage(true);
    	$quotes = $app['repository.quote']->getQuotes(true, $actualPage);

		return $app['twig']->render('blog/quotes.html', array(
			'quotes'     => $quotes,
			'actualPage' => $actualPage,
			'maxPage'   => $maxPage
		));
    }
}