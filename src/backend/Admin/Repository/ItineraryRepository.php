<?php

namespace Admin\Repository;

use Silex\Application;

class ItineraryRepository extends AbstractRepository
{
	/**
	 * Get itineraries by collection id
	 *
	 * @param integer $collectionId
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function getItineraries($collectionId)
	{
		$sql = 
<<<_SQL
SELECT id, collection_id, title, latitude, longitude
FROM itinerary
WHERE collection_id = :collectionId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':collectionId', $collectionId, \PDO::PARAM_INT);
        
        $statement->execute();

        if ($statement->rowCount() === 0) {
        	return null;
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Add itinerary for a collection id
	 *
	 * @param integer $collectionId
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function add($collectionId, $params)
	{
		$sql = 
<<<_SQL
INSERT INTO itinerary (`collection_id`, `title`, `latitude`, `longitude`)
VALUES (:collectionId, :title, :latitude, :longitude)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':collectionId', $collectionId, \PDO::PARAM_INT);
		$statement->bindValue(':title', $params['title'], \PDO::PARAM_STR);
		$statement->bindValue(':latitude', $params['latitude'], \PDO::PARAM_INT);
		$statement->bindValue(':longitude', $params['longitude'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Delete itinerary for a collection id
	 *
	 * @param integer $itineraryId
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function delete($itineraryId)
	{
		$sql = 
<<<_SQL
DELETE FROM itinerary
WHERE id = :itineraryId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':itineraryId', $itineraryId, \PDO::PARAM_INT);
        
        return $statement->execute();
	}
}