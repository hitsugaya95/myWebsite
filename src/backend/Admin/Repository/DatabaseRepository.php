<?php

namespace Admin\Repository;

use Silex\Application;

class DatabaseRepository extends AbstractRepository
{
	/**
	 * Get All collections
	 *
	 * @return array
	 */
	public function getCollections()
	{
		$sql = 
<<<_SQL
SELECT * FROM collection
_SQL;
		$statement = $this->getConn()->prepare($sql);
        $statement->execute();

		$collectionsFromDb = $statement->fetchAll(\PDO::FETCH_ASSOC);

		$collections = array();
		foreach ($collectionsFromDb as $collection) {
			$collections[$collection['flickr_id']] = $collection;
		}

		return $collections;
	}

	/**
	 * Get one collection
	 *
	 * @param integer $collectionId
	 *
	 * @return array
	 */
	public function getCollection($collectionId)
	{
		$sql = 
<<<_SQL
SELECT * FROM collection
WHERE id = :collectionId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':collectionId', $collectionId, \PDO::PARAM_INT);
        $statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get all albums from a collection
	 *
	 * @param integer $collectionId
	 *
	 * @return array
	 */
	public function getAlbumsByCollection($collectionId)
	{
		$sql = 
<<<_SQL
SELECT * FROM album
WHERE collection_id = :collectionId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':collectionId', $collectionId, \PDO::PARAM_INT);
        $statement->execute();

		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get all albums
	 *
	 * @return array
	 */
	public function getAlbums()
	{
		$sql = 
<<<_SQL
SELECT * FROM album
_SQL;
		$statement = $this->getConn()->prepare($sql);
        $statement->execute();

		$albumsFromDb = $statement->fetchAll(\PDO::FETCH_ASSOC);

		$albums = array();
		foreach ($albumsFromDb as $album) {
			$albums[$album['flickr_id']] = $album;
		}

		return $albums;
	}

	/**
	 * Get photos from an album
	 *
	 * @param integer $albumId
	 *
	 * @return array
	 */
	public function getPhotosFromAlbum($albumId)
	{
		$sql = 
<<<_SQL
SELECT * FROM photo
WHERE album_id = :albumId
ORDER BY date
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':albumId', $albumId, \PDO::PARAM_INT);
        $statement->execute();

		$photosFromDb = $statement->fetchAll(\PDO::FETCH_ASSOC);

		$photos = array();
		foreach ($photosFromDb as $photo) {
			$photo['images'] = array(
				"small" => sprintf('http://farm%s.staticflickr.com/%s/%s_%s_q.jpg', $photo['farm_id'], $photo['server_id'], $photo['flickr_id'], $photo['secret_id']),
				"large" => sprintf('http://farm%s.staticflickr.com/%s/%s_%s_b.jpg', $photo['farm_id'], $photo['server_id'], $photo['flickr_id'], $photo['secret_id']),
			);

			$photos[$photo['flickr_id']] = $photo;
		}

		return $photos;
	}

	/**
	 * Get one album
	 *
	 * @param integer $albumId
	 *
	 * @return array
	 */
	public function getAlbum($albumId)
	{
		$sql = 
<<<_SQL
SELECT * FROM album
WHERE id = :albumId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':albumId', $albumId, \PDO::PARAM_INT);
        $statement->execute();

		return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get all Photos
	 *
	 * @return array
	 */
	public function getPhotos()
	{
		$sql = 
<<<_SQL
SELECT * FROM photo
_SQL;
		$statement = $this->getConn()->prepare($sql);
        $statement->execute();

		$photosFromDb = $statement->fetchAll(\PDO::FETCH_ASSOC);

		$photos = array();
		foreach ($photosFromDb as $photo) {
			$photo['images'] = array(
				"small" => sprintf('http://farm%s.staticflickr.com/%s/%s_%s_q.jpg', $photo['farm_id'], $photo['server_id'], $photo['flickr_id'], $photo['secret_id']),
				"large" => sprintf('http://farm%s.staticflickr.com/%s/%s_%s_b.jpg', $photo['farm_id'], $photo['server_id'], $photo['flickr_id'], $photo['secret_id']),
			);

			$photos[$photo['flickr_id']] = $photo;
		}

		return $photos;
	}

	/**
	 * Get one photo
	 *
	 * @param integer $photoId
	 *
	 * @return array
	 */
	public function getPhoto($photoId)
	{
		$sql = 
<<<_SQL
SELECT * FROM photo
WHERE id = :photoId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':photoId', $photoId, \PDO::PARAM_INT);
        $statement->execute();

		$photo = $statement->fetch(\PDO::FETCH_ASSOC);

		$photo['images'] = array(
			"small" => sprintf('http://farm%s.staticflickr.com/%s/%s_%s_q.jpg', $photo['farm_id'], $photo['server_id'], $photo['flickr_id'], $photo['secret_id']),
			"large" => sprintf('http://farm%s.staticflickr.com/%s/%s_%s_b.jpg', $photo['farm_id'], $photo['server_id'], $photo['flickr_id'], $photo['secret_id']),
		);

		return $photo;
	}

	/**
	 * Insert Collection
	 *
	 * @param array $collection
	 *
	 */
	public function insertCollection($collection)
	{
		$sql = 
<<<_SQL
INSERT INTO collection (`flickr_id`, `title`, `description`, `image`, `count_album`)
VALUES (:flickrId, :title, :description, :image, :countAlbum)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':flickrId', $collection['id'], \PDO::PARAM_INT);
		$statement->bindValue(':title', $collection['title'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $collection['description'], \PDO::PARAM_STR);
		$statement->bindValue(':image', $collection['iconlarge'], \PDO::PARAM_STR);

		$countAlbum = count($collection['set']);
		$statement->bindValue(':countAlbum', $countAlbum, \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Insert Album
	 *
	 * @param array $albumInfo
	 *
	 */
	public function insertAlbum($album, $collectionId)
	{
		$sql = 
<<<_SQL
INSERT INTO album (`flickr_id`, `collection_id`, `title`, `description`, `image`, `count_picture`)
VALUES (:flickrId, :collectionId, :title, :description, :image, :countPicture)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':flickrId', $album['id'], \PDO::PARAM_INT);
		$statement->bindValue(':collectionId', $collectionId, \PDO::PARAM_INT);
		$statement->bindValue(':title', $album['title']['_content'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $album['description']['_content'], \PDO::PARAM_STR);
		$statement->bindValue(':image', $album['cover_photo'], \PDO::PARAM_STR);
        $statement->bindValue(':countPicture', $album['count_photos'], \PDO::PARAM_STR);

        return $statement->execute();
	}

	/**
	 * Update Collection
	 *
	 * @param array $collection
	 *
	 */
	public function updateCollection($collection)
	{
		$sql = 
<<<_SQL
UPDATE collection 
SET `title` = :title, `description` = :description, `image` = :image, `count_album` = :countAlbum
WHERE `flickr_id` = :flickrId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':flickrId', $collection['id'], \PDO::PARAM_INT);
		$statement->bindValue(':title', $collection['title'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $collection['description'], \PDO::PARAM_STR);
		$statement->bindValue(':image', $collection['iconlarge'], \PDO::PARAM_STR);

		$countAlbum = count($collection['set']);
		$statement->bindValue(':countAlbum', $countAlbum, \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Update Sql Collection
	 *
	 * @param integer $collectionId
	 * @param arary   $params
	 * 
	 * @return array
	 */
	public function updateSqlCollection($collectionId, $params)
	{
		$sql = 
<<<_SQL
UPDATE collection 
SET `title` = :title, `description` = :description
WHERE `id` = :collectionId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':title', $params['title'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $params['description'], \PDO::PARAM_STR);
		$statement->bindValue(':collectionId', $collectionId, \PDO::PARAM_INT);

		return $statement->execute();
	}

	/**
	 * Update Sql Album
	 *
	 * @param integer $albumId
	 * @param arary   $params
	 * 
	 * @return array
	 */
	public function updateSqlAlbum($albumId, $params)
	{
		$sql = 
<<<_SQL
UPDATE album 
SET `title` = :title, `description` = :description
WHERE `id` = :albumId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':title', $params['title'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $params['description'], \PDO::PARAM_STR);
		$statement->bindValue(':albumId', $albumId, \PDO::PARAM_INT);

		return $statement->execute();
	}

	/**
	 * Update Sql Photo
	 *
	 * @param integer $photoId
	 * @param arary   $params
	 * 
	 * @return array
	 */
	public function updateSqlPhoto($photoId, $params)
	{
		$sql = 
<<<_SQL
UPDATE photo 
SET `is_published` = :isPublished
WHERE `id` = :photoId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':isPublished', $params['is_published'], \PDO::PARAM_STR);
		$statement->bindValue(':photoId', $photoId, \PDO::PARAM_INT);

		return $statement->execute();
	}

	/**
	 * Is photo is already in database
	 *
	 * @param integer $flickrId
	 *
	 * @return boolean
	 */
	public function isPhotoInDB($flickId)
	{
		$sql = 
<<<_SQL
SELECT * 
FROM photo 
WHERE flickr_id = :flickrId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':flickrId', $flickId, \PDO::PARAM_INT);
		$statement->execute();

		return (bool) $statement->rowCount();
	}

	/**
	 * Insert Photo
	 *
	 * @param array $photo
	 * @param integer albumId
	 *
	 */
	public function insertPhoto($photo, $albumId)
	{
		$sql = 
<<<_SQL
INSERT INTO photo (`flickr_id`, `album_id`, `title`, `secret_id`, `server_id`, `farm_id`, `date`)
VALUES (:flickrId, :albumId, :title, :secretId, :serverId, :farmId, :date)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':flickrId', $photo['id'], \PDO::PARAM_INT);
		$statement->bindValue(':albumId', $albumId, \PDO::PARAM_INT);
		$statement->bindValue(':title', $photo['title'], \PDO::PARAM_STR);
		$statement->bindValue(':secretId', $photo['secret'], \PDO::PARAM_STR);
		$statement->bindValue(':serverId', $photo['server'], \PDO::PARAM_INT);
		$statement->bindValue(':farmId', $photo['farm'], \PDO::PARAM_INT);
        $statement->bindValue(':date', $photo['datetaken'], \PDO::PARAM_STR);

        return $statement->execute();
	}

	/**
	 * Set Cover photo to album
	 *
	 * @param integer photoId
	 *
	 */
	public function setCover($photoId)
	{
		// Get photo information
		$photo = $this->getPhoto($photoId);

		$sql = 
<<<_SQL
UPDATE album 
SET `image` = :image
WHERE `id` = :albumId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':image', $photo['images']['large'], \PDO::PARAM_STR);
		$statement->bindValue(':albumId', $photo['album_id'], \PDO::PARAM_INT);

        return $statement->execute();
	}
}