<?php

namespace JimmyPhimmasone\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ContactController
{
    public function sendEmailAction(Request $request, Application $app)
    {
    	$email = $request->get('email');
        $subject = $request->get('subject');
    	$message = $request->get('message');

    	if ($email == "") {
    		$error = "empty email";

        	return $app->json($error, 404);
    	} 

    	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    		$error = "incorrect email";

        	return $app->json($error, 404);
    	} 


    	if ($message == "") {
    		$error = "empty message";

        	return $app->json($error, 404);
    	}

    	$app['repository.contact']->sendEmail($email, $subject, $message);

    	return $app->json('success', 200);
    }
}