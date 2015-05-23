<?php

namespace Admin\Repository;

use Silex\Application;

class QuoteRepository extends AbstractRepository
{
	protected $limit = 15;

	/**
	 * Get Quotes collection
	 *
	 * @return mixed array 
	 */
	public function getQuotes($onlyEnabled=false, $page=1)
	{
		$sql = 
<<<_SQL
SELECT *
FROM quote
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
	 * Get Quotes collection
	 *
	 * @return mixed array 
	 */
	public function getQuotesMaxPage($onlyEnabled=false)
	{
		$sql = 
<<<_SQL
SELECT count(id)
FROM quote
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
	 * Get Quote
	 *
	 * @param integer $quoteId
	 *
	 * @return mixed array 
	 */
	public function getQuote($quoteId)
	{
		$sql = 
<<<_SQL
SELECT *
FROM quote
WHERE id = :quoteId
_SQL;
		$statement = $this->getConn()->prepare($sql);   
		$statement->bindValue(':quoteId', $quoteId, \PDO::PARAM_INT);     
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get Last Quote
	 *
	 * @return mixed array 
	 */
	public function getLastQuote()
	{
		$sql = 
<<<_SQL
SELECT *
FROM quote
WHERE is_enabled = 1
ORDER BY id DESC
LIMIT 1
_SQL;
		$statement = $this->getConn()->prepare($sql);       
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Add quote
	 *
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function add($params)
	{
		$sql = 
<<<_SQL
INSERT INTO quote (`author`, `date`, `city`, `country`, `quote`, `giphy`, `is_enabled`)
VALUES (:author, :date, :city, :country, :quote, :giphy, :isEnabled)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':author', $params['author'], \PDO::PARAM_STR);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':city', $params['city'], \PDO::PARAM_STR);
		$statement->bindValue(':country', $params['country'], \PDO::PARAM_STR);
		$statement->bindValue(':quote', $params['quote'], \PDO::PARAM_STR);
		$statement->bindValue(':giphy', $params['giphy'], \PDO::PARAM_STR);
		$statement->bindValue(':isEnabled', $params['isEnabled'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Modify quote
	 *
	 * @param integer $quoteId
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function modify($quoteId, $params)
	{
		$sql = 
<<<_SQL
UPDATE quote 
SET `author` = :author, `date` = :date, `city` = :city, `country` = :country, `quote` = :quote, `giphy` = :giphy, `is_enabled` = :isEnabled
WHERE `id` = :quoteId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':quoteId', $quoteId, \PDO::PARAM_INT);
		$statement->bindValue(':author', $params['author'], \PDO::PARAM_STR);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':city', $params['city'], \PDO::PARAM_STR);
		$statement->bindValue(':country', $params['country'], \PDO::PARAM_STR);
		$statement->bindValue(':quote', $params['quote'], \PDO::PARAM_STR);
		$statement->bindValue(':giphy', $params['giphy'], \PDO::PARAM_STR);
		$statement->bindValue(':isEnabled', $params['isEnabled'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Delete quote
	 *
	 * @param integer $quoteId
	 *
	 * @return bool
	 */
	public function delete($quoteId)
	{
		$sql = 
<<<_SQL
DELETE FROM quote
WHERE id = :id
_SQL;

		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':id', $quoteId, \PDO::PARAM_INT);

        return $statement->execute();
	}
}