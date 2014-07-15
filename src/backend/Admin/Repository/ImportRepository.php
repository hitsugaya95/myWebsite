<?php

namespace Admin\Repository;

use Silex\Application;

class ImportRepository extends AbstractRepository
{
	protected $databaseRepository;

	public function getDatabaseRepository()
	{
		if (null === $this->databaseRepository) {
			$this->databaseRepository = $this->getRepository('Database');
		}

		return $this->databaseRepository;
	}

	/**
	 * Import collections from Flickr
	 */
	public function importCollections()
	{
		$collections = $this->getDatabaseRepository()->getCollections();

		$collectionsFromFlickr = $this->getFlickr()->getCollections();

		$import = array(
			"add"    => array(),
			"update" => array()
		);

		foreach ($collectionsFromFlickr as $collection) {
			if (isset($collections[$collection['id']])) {
				if ($collections[$collection['id']]['count_album'] != count($collection['set'])) {
					// UPDATE
					$this->getDatabaseRepository()->updateCollection($collection);

					$import['update'][] = $collection['title'];
				}
			} else {
				// INSERT
				$this->getDatabaseRepository()->insertCollection($collection);

				$import['add'][] = $collection['title'];
			}
		}

		return $import;
	}

	/**
	 * Import Albums From Flickr
	 */
	public function importAlbums()
	{
		$albums = $this->getDatabaseRepository()->getAlbums();

		$collections = $this->getDatabaseRepository()->getCollections();

		$albumsFromFlickr = array();
		foreach ($collections as $collection) {
			$albumsFromFlickr[$collection['id']] = $this->getFlickr()->getAlbumsFromCollection($collection['flickr_id']);
		}
		
		$import = array(
			"add"    => array(),
			"update" => array()
		);

		foreach ($albumsFromFlickr as $collectionId => $albumFromFlickr) {
			foreach ($albumFromFlickr as $album) {
				if (!isset($albums[$album['id']])) {
					$albumInfo = $this->getFlickr()->getAlbumInfo($album['id']);
					$this->getDatabaseRepository()->insertAlbum($albumInfo, $collectionId);

					$import['add'][] = $albumInfo['title']['_content'];
				}
			}
		}

		return $import;
	}

	/**
	 * Import Photos From Flickr
	 */
	public function importPhotos()
	{
		$albums = $this->getDatabaseRepository()->getAlbums();

		$photosFromFlickr = array();
		foreach ($albums as $album) {
			$photosFromFlickr[$album['id']] = $this->getFlickr()->getPhotosFromAlbum($album['flickr_id']);
		}
		
		$add = 0;

		foreach ($photosFromFlickr as $albumId => $photoFromFlickr) {
			foreach ($photoFromFlickr as $photo) {
				if ($this->getDatabaseRepository()->isPhotoInDB($photo['id']) === false) {
					$this->getDatabaseRepository()->insertPhoto($photo, $albumId);

					$add ++;
				}
			}
		}

		return $add;
	}
}