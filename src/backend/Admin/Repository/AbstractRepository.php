<?php

namespace Admin\Repository;

use Silex\Application;

abstract class AbstractRepository
{
	protected $flickr;
	protected $db;
	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->db = $app['db'];
		$this->flickr = $app['service.flickr'];
	}

	public function getApp()
	{
		return $this->app;
	}

	public function getConn()
	{
		return $this->db;
	}

	public function getFlickr()
	{
		return $this->flickr;
	}

	public function getRepository($className)
	{
		$class = sprintf('Admin\\Repository\\%sRepository', $className);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('No Repository class %s found', $className));
        }

        return new $class($this->getApp());
	}
}