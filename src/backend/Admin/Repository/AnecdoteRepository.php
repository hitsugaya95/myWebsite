<?php

namespace Admin\Repository;

use Silex\Application;

class AnecdoteRepository extends AbstractRepository
{
	protected $limit = 10;

	/**
	 * Get Anecdotes collection
	 *
	 * @return mixed array 
	 */
	public function getAnecdotes($onlyEnabled=false, $page=1)
	{
		$sql = 
<<<_SQL
SELECT *
FROM anecdote
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
	 * Get Anecdotes collection
	 *
	 * @return mixed array 
	 */
	public function getAnecdotesMaxPage($onlyEnabled=false)
	{
		$sql = 
<<<_SQL
SELECT count(id)
FROM anecdote
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
	 * Get Anecdote
	 *
	 * @param integer $quoteId
	 *
	 * @return mixed array 
	 */
	public function getAnecdote($anecdoteId)
	{
		$sql = 
<<<_SQL
SELECT *
FROM anecdote
WHERE id = :anecdoteId
_SQL;
		$statement = $this->getConn()->prepare($sql);   
		$statement->bindValue(':anecdoteId', $anecdoteId, \PDO::PARAM_INT);     
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Get Last Anecdote
	 *
	 * @return mixed array 
	 */
	public function getLastAnecdote()
	{
		$sql = 
<<<_SQL
SELECT *
FROM anecdote
WHERE is_enabled = 1
ORDER BY id DESC
LIMIT 1
_SQL;
		$statement = $this->getConn()->prepare($sql);       
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Add anecdote
	 *
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function add($params)
	{
		$sql = 
<<<_SQL
INSERT INTO anecdote (`date`, `image`, `anecdote`, `is_enabled`)
VALUES (:date, :image, :anecdote, :isEnabled)
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':image', $params['image'], \PDO::PARAM_STR);
		$statement->bindValue(':anecdote', $params['anecdote'], \PDO::PARAM_STR);
		$statement->bindValue(':isEnabled', $params['isEnabled'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Modify anecdote
	 *
	 * @param integer $quoteId
	 * @param array $params
	 *
	 * @return mixed array on success, otherwise null
	 */
	public function modify($anecdoteId, $params)
	{
		$sql = 
<<<_SQL
UPDATE anecdote 
SET `date` = :date, `image` = :image, `anecdote` = :anecdote, `is_enabled` = :isEnabled
WHERE `id` = :anecdoteId
_SQL;
		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':anecdoteId', $anecdoteId, \PDO::PARAM_INT);
		$statement->bindValue(':date', $params['date']->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
		$statement->bindValue(':image', $params['image'], \PDO::PARAM_STR);
		$statement->bindValue(':anecdote', $params['anecdote'], \PDO::PARAM_STR);
		$statement->bindValue(':isEnabled', $params['isEnabled'], \PDO::PARAM_INT);
        
        return $statement->execute();
	}

	/**
	 * Delete anecdote
	 *
	 * @param integer $anecdoteId
	 *
	 * @return bool
	 */
	public function delete($anecdoteId)
	{
		$sql = 
<<<_SQL
DELETE FROM anecdote
WHERE id = :id
_SQL;

		$statement = $this->getConn()->prepare($sql);
		$statement->bindValue(':id', $anecdoteId, \PDO::PARAM_INT);

        return $statement->execute();
	}
}