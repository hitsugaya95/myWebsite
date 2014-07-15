<?php
 
namespace Service;
 
class Flickr 
{
    private     $app_key    = '5a5a52e1758bb612436f60f3eb69f45f';
    private     $app_secret = '514e90dd5e0fba10';
    private     $user_id    = '97367986@N06';
    protected   $url_api    = 'https://api.flickr.com/services/rest/?';
    protected   $params;
   
    /**
     * Construct method
     * 
     */
    public function __construct()
    {
        // Set Params
        $this->params = array(
            'api_key'        => $this->app_key,
            'user_id'        => $this->user_id,
            'format'         => 'json',
            'nojsoncallback' => '1', 
        );    
    }
    
    /**
     * Encode params to set to an URL
     * 
     * @param array $params
     * 
     * @return array encoded_params
     */
    private function encoded_params($params)
    {
        // Initialize array
        $encoded_params = array();

        // Encode each params
        foreach ($params as $index => $value) {
            $encoded_params[] = urlencode($index).'='.urlencode($value);
        }
        return $encoded_params;
    }
    
    /**
     * Get JSON data from Flickr API
     * 
     * @param array $params
     * 
     * @return array response from API
     */
    private function get_json($params)
    {
        // Construct URL by setting parameters
        $url = $this->url_api. \implode('&', $params);

        // Get response from API 
        $response = file_get_contents($url);

        // Parameters set to TRUE to have a array
        return json_decode($response, true);
    }
    
    /**
     * Call Flickr API
     * 
     * @return array data from API
     */
    private function call_api()
    {
        // Encoded params
        $encoded_params = $this->encoded_params($this->params);

        // Call Flickr Api
        return $this->get_json($encoded_params);
    }
    
    /**
     * Return all Collection from Flickr API 
     * 
     * @return string method
     */
    public function getCollections()
    {
        // Set method
        $this->params['method'] = 'flickr.collections.getTree';

        // Call Flickr Api
        $collections = $this->call_api();

        return $collections['collections']['collection'];
    }

    /**
     * Return list of albums from a collection
     * 
     * @return string array
     */
    public function getAlbumsFromCollection($collectionId)
    {
        // Set method
        $this->params['method'] = 'flickr.collections.getTree';
        $this->params['collection_id'] = $collectionId;

        // Call Flickr Api
        $collections = $this->call_api();

        foreach ($collections["collections"]["collection"] as $collection) {
            return $collection["set"];
        }
    }

    /**
     * Return album info
     * 
     * @return string array
     */
    public function getAlbumInfo($albumId)
    {
        // Set method
        $this->params['method'] = 'flickr.photosets.getInfo';
        $this->params['photoset_id'] = $albumId;

        // Call Flickr Api
        $albumInfo = $this->call_api();

        $albumInfo = $albumInfo['photoset'];
        $albumInfo['cover_photo'] = sprintf('http://farm%s.staticflickr.com/%s/%s_%s_b.jpg', $albumInfo['farm'], $albumInfo['server'], $albumInfo['primary'], $albumInfo['secret']);

        return $albumInfo;
    }

    /**
     * Return all album from Flickr API 
     * 
     * @return string method
     */
    public function getAlbums()
    {
        // Set method
        $this->params['method'] = 'flickr.photosets.getList';

        // Call Flickr Api
        $albums = $this->call_api();

        return $albums['photosets']['photoset'];
    }
    
    /**
     * Get Photos from an album
     * 
     * @param type $album_id
     * 
     * @return array photos
     */
    public function getPhotosFromAlbum($album_id)
    {
        // Set method
        $this->params['method'] = 'flickr.photosets.getPhotos';
        $this->params['photoset_id'] = $album_id;
        $this->params['extras'] = 'date_taken';

        // Call Flickr Api
        $photos = $this->call_api();

        return $photos['photoset']['photo'];
    }
}   
