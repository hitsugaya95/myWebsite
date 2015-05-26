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

	/**
	 * Add comment
	 *
	 * @param integer $impressionId
	 * @param array $params
	 *
	 * @return bool
	 */
	public function addComment($impressionId, $params)
	{
		$sql = 
<<<_SQL
INSERT INTO comment (`impression_id`, `name`, `date`, `email`, `comment`, `is_new`, `is_published`)
VALUES (:impressionId, :name, :date, :email, :comment, :isNew, :isPublished)
_SQL;

		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':impressionId', $impressionId, \PDO::PARAM_INT);
		$statement->bindValue(':name', $params['name'], \PDO::PARAM_STR);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':email', $params['email'], \PDO::PARAM_STR);
		$statement->bindValue(':comment', $params['comment'], \PDO::PARAM_STR);
		$statement->bindValue(':isNew', $params['isNew'], \PDO::PARAM_INT);
		$statement->bindValue(':isPublished', $params['isPublished'], \PDO::PARAM_INT);

        return $statement->execute();
	}

	/**
	 * Retrieve comments by impression
	 *
	 * @param integer $impressionId
	 * @param boolean $onlyPublished
	 *
	 * @return array
	 */
	public function getCommentsByImpression($impressionId, $onlyPublished=false)
	{
		$sql = 
<<<_SQL
SELECT *
FROM comment
WHERE impression_id = :impressionId
_SQL;
		
		if (true === $onlyPublished) {
			$sql .= 
<<<_SQL

AND is_published = 1
_SQL;
		}

		$sql .= 
<<<_SQL

ORDER BY id DESC
_SQL;

		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':impressionId', $impressionId, \PDO::PARAM_INT); 
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Retrieve new comments that are not viewed
	 *
	 * @return array
	 */
	public function getNewComments()
	{
		$sql = 
<<<_SQL
SELECT comment.id, comment.name, comment.email, comment.date, comment.comment, impression.title as impression_title
FROM comment as comment
LEFT JOIN impression as impression ON impression.id = comment.impression_id
WHERE is_new = 1
_SQL;

		$statement = $this->getConn()->prepare($sql);    
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * Set false to is_new field
	 *
	 * @param integer $commentId
	 *
	 * @return array
	 */
	public function viewComment($commentId)
	{
		$sql = 
<<<_SQL
UPDATE comment 
SET `is_new` = 0
WHERE `id` = :commentId
_SQL;

		$statement = $this->getConn()->prepare($sql);  
		$statement->bindValue(':commentId', $commentId, \PDO::PARAM_INT);  
        
        return $statement->execute();
	}

	/**
	 * Publish comment
	 *
	 * @param integer $commentId
	 *
	 * @return array
	 */
	public function publishComment($commentId)
	{
		$sql = 
<<<_SQL
UPDATE comment 
SET `is_published` = 1
WHERE `id` = :commentId
_SQL;

		$statement = $this->getConn()->prepare($sql);  
		$statement->bindValue(':commentId', $commentId, \PDO::PARAM_INT);  
        
        return $statement->execute();
	}

	/**
	 * Unpublish comment
	 *
	 * @param integer $commentId
	 *
	 * @return array
	 */
	public function unpublishComment($commentId)
	{
		$sql = 
<<<_SQL
UPDATE comment 
SET `is_published` = 0
WHERE `id` = :commentId
_SQL;

		$statement = $this->getConn()->prepare($sql);  
		$statement->bindValue(':commentId', $commentId, \PDO::PARAM_INT);  
        
        return $statement->execute();
	}
}