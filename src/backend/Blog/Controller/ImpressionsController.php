<?php

namespace Blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ImpressionsController
{
	protected $month = [
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

    public function indexAction(Request $request, Application $app)
    {
    	$actualPage = null !== $request->get('page') ? $request->get('page') : 1;
    	$maxPage = $app['repository.impression']->getImpressionsMaxPage(true);
    	$impressions = $app['repository.impression']->getImpressions(true, $actualPage);

        foreach ($impressions as &$impression) {
        	$date = new \Datetime($impression['date']);
        	$impression['date_formatted'] = $date->format('d'). ' '.$this->month[$date->format('F')].' '.$date->format('Y');
        }

		return $app['twig']->render('blog/impressions.html', array(
			'impressions' => $impressions,
			'actualPage'  => $actualPage,
			'maxPage'     => $maxPage
		));
    }

    public function impressionAction($impressionId, Request $request, Application $app)
    {
    	$impression = $app['repository.impression']->getImpression($impressionId);

    	if (false == $impression) {
    		return $app->abort(404, "Impression {$impressionId} does not exist.");
    	}

    	if (false == $impression['is_enabled']) {
    		return $app->abort(404, "Impression {$impressionId} does not exist.");
    	}

    	$previousImpression = $app['repository.impression']->getPreviousImpression($impressionId);
    	$nextImpression = $app['repository.impression']->getNextImpression($impressionId);

    	$date = new \Datetime($impression['date']);
        $impression['date_formatted'] = $date->format('d'). ' '.$this->month[$date->format('F')].' '.$date->format('Y');

		return $app['twig']->render('blog/impression.html', array(
			'impression'         => $impression,
			'previousImpression' => $previousImpression,
			'nextImpression'     => $nextImpression
		));
    }
}