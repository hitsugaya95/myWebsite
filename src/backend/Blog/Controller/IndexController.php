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
        $impression = $app['repository.impression']->getLastImpression();

		return $app['twig']->render('blog/index.html', array(
			'quote'     => $quote,
            'anecdote'  => $anecdote,
			'impression' => $impression,
		));
    }
}