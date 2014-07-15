<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ItineraryController
{
    public function itineraryAction($collectionId, Request $request, Application $app)
    {
    	$collection = $app['repository.database']->getCollection($collectionId);
    	$itineraries = $app['repository.itinerary']->getItineraries($collectionId);

		return $app['twig']->render('/admin/itinerary.html', array("collection" => $collection, "itineraries" => $itineraries));
    }

    /**
     * Search latitude and longitude by AJAX
     *
     */
    public function searchAction(Request $request, Application $app)
    {
    	$address = $request->get('address');

    	$geocode = $app['service.googlemaps']->searchByAddress($address);

    	return $app->json($geocode, 200);
    }

    /**
     * Add geolocalisation
     *
     */
    public function addAction($collectionId, Request $request, Application $app)
    {	
    	$params = array(
    		"title" => $request->get('title'),
    		"latitude" => $request->get('latitude'),
    		"longitude" => $request->get('longitude'),
    	);

    	$app['repository.itinerary']->add($collectionId, $params);

    	return $app->json('success', 200);
    }

    /**
     * Delete geolocalisation
     *
     */
    public function deleteAction(Request $request, Application $app)
    {	
    	$app['repository.itinerary']->delete($request->get('itineraryId'));

    	return $app->json('success', 200);
    }
}