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

    public function previewAnecdoteAction($anecdoteId, Request $request, Application $app)
    {      
        return $app['twig']->render('/admin/blog/preview_anecdote.html', array(
            "anecdote" => $app['repository.anecdote']->getAnecdote($anecdoteId),
        ));
    }

    public function impressionsAction(Request $request, Application $app)
    {      
        $actualPage = null !== $request->get('page') ? $request->get('page') : 1;
        $maxPage = $app['repository.impression']->getImpressionsMaxPage();
        $impressions = $app['repository.impression']->getImpressions(false, $actualPage);

        return $app['twig']->render('admin/blog/impressions.html', array(
            'impressions'     => $impressions,
            'actualPage' => $actualPage,
            'maxPage'   => $maxPage
        ));
    }

    public function addImpressionsAction(Request $request, Application $app)
    {
        if (0 < count($request->getQueryString())) {
            // Add quote in database
            $params = array(
                "author"      => $request->get('author'),
                "date"        => new \DateTime(str_replace('/', '-', $request->get('date'))),
                "city"        => $request->get('city'),
                "image"       => $request->get('image'),
                "title"       => $request->get('title'),
                "description" => $request->get('description'),
                "impression"  => $request->get('impression'),
                "isEnabled"   => null !== $request->get('isEnabled') ? true : false,
            );

            $result = $app['repository.impression']->add($params);

            return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
        }

        return $app['twig']->render('/admin/blog/add_impressions.html', array());
    }

    public function modifyImpressionAction($impressionId, Request $request, Application $app)
    {
        if (0 < count($request->getQueryString())) {
            // Add quote in database
            $params = array(
                "author"      => $request->get('author'),
                "date"        => new \DateTime(str_replace('/', '-', $request->get('date'))),
                "city"        => $request->get('city'),
                "image"       => $request->get('image'),
                "title"       => $request->get('title'),
                "description" => $request->get('description'),
                "impression"  => $request->get('impression'),
                "isEnabled"   => null !== $request->get('isEnabled') ? true : false,
            );

            $result = $app['repository.impression']->modify($impressionId, $params);

            return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
        }

        return $app['twig']->render('/admin/blog/modify_impressions.html', array(
            "impression" => $app['repository.impression']->getImpression($impressionId),
        ));
    }

    public function deleteImpressionsAction($impressionId, Request $request, Application $app)
    {
        $app['repository.impression']->delete($impressionId);

        return $app->redirect('/admin/blog/impressions/');
    }

    public function previewImpressionAction($impressionId, Request $request, Application $app)
    {      
        $impression = $app['repository.impression']->getImpression($impressionId);

        $month = [
        'January' => 'Janvier',
        'February' => 'Février',
        'March' => 'Mars',
        'April' => 'Avril',
        'May' => 'Mai',
        'June' => 'Juin',
        'July' => 'Juillet',
        'August' => 'Aout',
        'September' => 'Septembre',
        'October' => 'Octobre',
        'November' => 'Novembre',
        'December' => 'Décembre',
        ];

        $date = new \Datetime($impression['date']);
        $impression['date_formatted'] = $date->format('d'). ' '.$month[$date->format('F')].' '.$date->format('Y');

        return $app['twig']->render('/admin/blog/preview_impression.html', array(
            "impression" => $impression,
        ));
    }

    public function commentsImpressionAction($impressionId, Request $request, Application $app)
    {
        $impression = $app['repository.impression']->getImpression($impressionId);
        $comments = $app['repository.impression']->getCommentsByImpression($impressionId);

        return $app['twig']->render('/admin/blog/comments.html', array(
            "comments"   => $comments,
            "impression" => $impression
        ));
    }

    public function newCommentsAction(Request $request, Application $app)
    {    
        $comments = $app['repository.impression']->getNewComments();

        foreach ($comments as $comment) {
            $app['repository.impression']->viewComment($comment['id']);
        } 

        return $app['twig']->render('/admin/blog/new_comments.html', array(
            "comments" => $comments,
        ));
    }

    public function publishedCommentAction($commentId, Request $request, Application $app)
    {    
        $result = $app['repository.impression']->publishComment($commentId);

        return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
    }

    public function unpublishedCommentAction($commentId, Request $request, Application $app)
    {    
        $result = $app['repository.impression']->unpublishComment($commentId);

        return (true == $result) ? $app->json($result, 200) : $app->json($result, 500);
    }

}