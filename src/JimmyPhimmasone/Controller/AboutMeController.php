<?php

namespace JimmyPhimmasone\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class AboutMeController
{
    public function indexAction(Request $request, Application $app)
    {
		return $app['twig']->render('about_me.html', array('teest' => 'tedrt('));
    }
}