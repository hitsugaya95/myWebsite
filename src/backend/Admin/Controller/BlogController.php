<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class BlogController
{
    public function quotesAction(Request $request, Application $app)
    {      
        $actualPage = null !== $request->get('page') ? $request->get('page') : 1;
        $maxPage = $app['repository.quote']->getQuotesMaxPage();
        $quotes = $app['repository.quote']->getQuotes(false, $actualPage);

        return $app['twig']->render('admin/blog/quotes.html', array(
            'quotes'     => $quotes,
            'actualPage' => $actualPage,
            'maxPage'   => $maxPage
        ));
    }

    public function addQuotesAction(Request $request, Application $app)
    {
        if (0 < count($request->getQueryString())) {
            // Add quote in database
            $params = array(
                "author"  => $request->get('author'),
                "date"    => new \DateTime(str_replace('/', '-', $request->get('date'))),
                "city"    => $request->get('city'),
                "country" => $request->get('country'),
                "quote"   => $request->get('quote'),
                "giphy"   => '' == $request->get('giphy') ? null : $request->get('giphy'),
                "isEnabled" => null !== $request->get('isEnabled') ? true : false,
            );

            $result = $app['repository.quote']->add($params);

            return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
        }

        return $app['twig']->render('/admin/blog/add_quotes.html', array());
    }

    public function modifyQuoteAction($quoteId, Request $request, Application $app)
    {
        if (0 < count($request->getQueryString())) {
            // Add quote in database
            $params = array(
                "author"  => $request->get('author'),
                "date"    => new \DateTime(str_replace('/', '-', $request->get('date'))),
                "city"    => $request->get('city'),
                "country" => $request->get('country'),
                "quote"   => $request->get('quote'),
                "giphy"   => '' == $request->get('giphy') ? null : $request->get('giphy'),
                "isEnabled" => null !== $request->get('isEnabled') ? true : false,
            );

            $result = $app['repository.quote']->modify($quoteId, $params);

            return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
        }

        return $app['twig']->render('/admin/blog/modify_quotes.html', array(
            "quote" => $app['repository.quote']->getQuote($quoteId),
        ));
    }

    public function deleteQuotesAction($quoteId, Request $request, Application $app)
    {
        $app['repository.quote']->delete($quoteId);

        return $app->redirect('/admin/blog/quotes/');
    }

    public function anecdotesAction(Request $request, Application $app)
    {      
        $actualPage = null !== $request->get('page') ? $request->get('page') : 1;
        $maxPage = $app['repository.anecdote']->getAnecdotesMaxPage();
        $anecdotes = $app['repository.anecdote']->getAnecdotes(false, $actualPage);

        return $app['twig']->render('admin/blog/anecdotes.html', array(
            'anecdotes'     => $anecdotes,
            'actualPage' => $actualPage,
            'maxPage'   => $maxPage
        ));
    }

    public function addAnecdotesAction(Request $request, Application $app)
    {
        if (0 < count($request->getQueryString())) {
            // Add quote in database
            $params = array(
                "date"    => new \DateTime(str_replace('/', '-', $request->get('date'))),
                "image"    => $request->get('image'),
                "anecdote" => $request->get('anecdote'),
                "isEnabled" => null !== $request->get('isEnabled') ? true : false,
            );

            $result = $app['repository.anecdote']->add($params);

            return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
        }

        return $app['twig']->render('/admin/blog/add_anecdotes.html', array());
    }

    public function modifyAnecdoteAction($anecdoteId, Request $request, Application $app)
    {
        if (0 < count($request->getQueryString())) {
            // Add quote in database
            $params = array(
                "date"    => new \DateTime(str_replace('/', '-', $request->get('date'))),
                "image"    => $request->get('image'),
                "anecdote" => $request->get('anecdote'),
                "isEnabled" => null !== $request->get('isEnabled') ? true : false,
            );

            $result = $app['repository.anecdote']->modify($anecdoteId, $params);

            return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
        }

        return $app['twig']->render('/admin/blog/modify_anecdotes.html', array(
            "anecdote" => $app['repository.anecdote']->getAnecdote($anecdoteId),
        ));
    }

    public function deleteAnecdotesAction($anecdoteId, Request $request, Application $app)
    {
        $app['repository.anecdote']->delete($anecdoteId);

        return $app->redirect('/admin/blog/anecdotes/');
    }
}