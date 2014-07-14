<?php

namespace JimmyPhimmasone\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
		return $app['twig']->render('index.html', array('teest' => 'tedrt('));
    }
}