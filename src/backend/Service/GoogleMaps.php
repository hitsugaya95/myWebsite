<?php
 
namespace Service;
 
class GoogleMaps 
{
    /**
     * Search by Address
     * 
     * @param string $address
     * 
     * @return array lat and long
     */
    public function searchByAddress($address)
    {
        $prepAddr = str_replace(' ', '+', $address);
        $url = sprintf('http://maps.google.com/maps/api/geocode/json?address=%s&sensor=false', $prepAddr);
        $geocode = file_get_contents($url);
        $output = json_decode($geocode);

        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;

        return array($latitude, $longitude);
    }
}   
