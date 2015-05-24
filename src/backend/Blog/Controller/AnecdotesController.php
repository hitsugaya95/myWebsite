<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AnecdotesController
{
    public function indexAction(Request $request, Application $app)
    {
    	$actualPage = null !== $request->get('page') ? $request->get('page') : 1;
    	$maxPage = $app['repository.anecdote']->getAnecdotesMaxPage(true);
    	$anecdotes = $app['repository.anecdote']->getAnecdotes(true, $actualPage);

		return $app['twig']->render('blog/anecdotes.html', array(
			'anecdotes'  => $anecdotes,
			'actualPage' => $actualPage,
			'maxPage'    => $maxPage
		));
    }
}