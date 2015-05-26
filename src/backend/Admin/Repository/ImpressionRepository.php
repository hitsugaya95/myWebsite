<?php

namespace Admin\Repository;

use Silex\Application;

class ImpressionRepository extends AbstractRepository
{
	protected $limit = 10;

	/**
	 * Get Impressions collection
	 *
	 * @return mixed array 
	 */
	public function getImpressions($onlyEnabled=false, $page=1)
	{
		$sql = 
<<<_SQL
SELECT *
FROM impression
_SQL;
		if (true === $onlyEnabled) {
			$sql .= 
<<<_SQL

WHERE is_enabled = 1
_SQL;
		}

		$sql .= 
<<<_SQL

ORDER BY id DESC
LIMIT :limit OFFSET :offset
_SQL;

		$statement = $this->getConn()->prepare($sql);   
		$statement->bindValue(':limit', $this->limit, \PDO::PARAM_INT);  

		$offset = ($page - 1) * $this->limit;
		$statement->bindValue(':offset', $offset, \PDO::PARAM_INT);       
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get Impressions max per page
	 *
	 * @return mixed array 
	 */
	public function getImpressionsMaxPage($onlyEnabled=false)
	{
		$sql = 
<<<_SQL
SELECT count(id)
FROM impression
_SQL;
		if (true === $onlyEnabled) {
			$sql .= 
<<<_SQL

WHERE is_enabled = 1
_SQL;
		}

		$statement = $this->getConn()->prepare($sql);       
        $statement->execute();

        $count = $statement->fetch(\PDO::FETCH_COLUMN);

        return ceil($count/$this->limit);
	}

	/**
	 * Get Impression
	 *
	 * @param integer $impressionId
	 *
	 * @return mixed array 
	 */
	public function getImpression($impressionId)
	{
		$sql = 
<<<_SQL
SELECT *
FROM impression
WHERE id = :impressionId
_SQL;
		$statement = $this->getConn()->prepare($sql);   
		$statement->bindValue(':impressionId', $impressionId, \PDO::PARAM_INT);     
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get Last Impression
	 *
	 * @return mixed array 
	 */
	public function getLastImpression()
	{
		$sql = 
<<<_SQL
SELECT *
FROM impression
WHERE is_enabled = 1
ORDER BY id DESC
LIMIT 1
_SQL;
		$statement = $this->getConn()->prepare($sql);       
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get Previous Impression
	 *
	 * @param integer $impressionId
	 *
	 * @return mixed array 
	 */
	public function getPreviousImpression($impressionId)
	{
		$sql = 
<<<_SQL
SELECT *
FROM impression
WHERE id < :impressionId
AND is_enabled = 1
LIMIT 1
_SQL;
		$statement = $this->getConn()->prepare($sql);   
		$statement->bindValue(':impressionId', $impressionId, \PDO::PARAM_INT);     
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get Next Impression
	 *
	 * @param integer $impressionId
	 *
	 * @return mixed array 
	 */
	public function getNextImpression($impressionId)
	{
		$sql = 
<<<_SQL
SELECT *
FROM impression
WHERE id > :impressionId
AND is_enabled = 1
LIMIT 1
_SQL;
		$statement = $this->getConn()->prepare($sql);   
		$statement->bindValue(':impressionId', $impressionId, \PDO::PARAM_INT);     
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Add impression
	 *
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function add($params)
	{
		$sql = 
<<<_SQL
INSERT INTO impression (`author`, `date`, `city`, `title`, `description`, `image`, `impression`, `is_enabled`)
VALUES (:author, :date, :city, :title, :description, :image, :impression, :isEnabled)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':author', $params['author'], \PDO::PARAM_STR);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':city', $params['city'], \PDO::PARAM_STR);
		$statement->bindValue(':title', $params['title'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $params['description'], \PDO::PARAM_STR);
		$statement->bindValue(':image', $params['image'], \PDO::PARAM_STR);
		$statement->bindValue(':impression', $params['impression'], \PDO::PARAM_STR);
		$statement->bindValue(':isEnabled', $params['isEnabled'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Modify impression
	 *
	 * @param integer $quoteId
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function modify($impressionId, $params)
	{
		$sql = 
<<<_SQL
UPDATE impression 
SET `author` = :author, `date` = :date, `city` = :city, `title` = :title, `description` = :description, `image` = :image, `impression` = :impression, `is_enabled` = :isEnabled
WHERE `id` = :impressionId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':impressionId', $impressionId, \PDO::PARAM_INT);
		$statement->bindValue(':author', $params['author'], \PDO::PARAM_STR);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':city', $params['city'], \PDO::PARAM_STR);
		$statement->bindValue(':title', $params['title'], \PDO::PARAM_STR);
		$statement->bindValue(':description', $params['description'], \PDO::PARAM_STR);
		$statement->bindValue(':image', $params['image'], \PDO::PARAM_STR);
		$statement->bindValue(':impression', $params['impression'], \PDO::PARAM_STR);
		$statement->bindValue(':isEnabled', $params['isEnabled'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Delete impression
	 *
	 * @param integer $impressionId
	 *
	 * @return bool
	 */
	public function delete($impressionId)
	{
		$sql = 
<<<_SQL
DELETE FROM impression
WHERE id = :id
_SQL;

		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':id', $impressionId, \PDO::PARAM_INT);

        return $statement->execute();
	}
}