<?php

namespace Admin\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
	protected $request;
	protected $app;

	public function __construct(Request $request, Application $app)
	{
		$this->request = $request;
		$this->app     = $app;
	}

	/**
	 * Get repository
	 *
	 * @param string $repository repository name
	 *
	 * @return repository
	 */
	public function getRepository($repository)
	{
		return $this->app['repository.' . $repository];
	}

	/**
	 * Render twig template
	 *
	 * @param string $template template path
	 * @param array  $variables
	 *
	 * @return twig rendering
	 */
	public function render($template, array $vars)
	{
		return $this->app['twig']->render($template, $vars);
	}

	/**
	 * Redirect
	 *
	 * @param string $uri
	 *
	 * @return redirection
	 */
	public function redirect($uri)
	{
		return $this->app->redirect($uri);
	}
}