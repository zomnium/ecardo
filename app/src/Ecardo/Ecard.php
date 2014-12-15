<?php

/**
 * Ecardo - Easy to use e-card sender
 * @author      Tim van Bergenhenegouwen
 * @link        http://o-utrecht.nl/
 * @copyright   2014 O-utrecht, Tim van Bergenhenegouwen
 */

namespace Ecardo;

use \Ecardo\App as Application;
use \Symfony\Component\Validator\Constraints as Assert;
use \Symfony\Component\HttpFoundation\Request as Request;

abstract class Ecard
{
	protected $app;

	/**
	 * Constructor
	 * @param string $name 
	 * @param string $controller
	 */

	public function __construct($name, $controller)
	{
		// Get singleton instance of the application
		$this->app = Application::getInstance();

		// Register route and Twig service provider
		$this->app->silex->match('/'.$name, $controller)
			 ->before(array($this, 'registerTwigServiceProvider'));
	}

	/**
	 * Register Twig Service Provider
	 *
	 * @param request $request Current request from the HTTP Foundation
	 */

	public function registerTwigServiceProvider(Request $request)
	{
		// Load Twig service provider and set default path
		$this->app->silex->register(new \Silex\Provider\TwigServiceProvider(), array(
			'twig.path' => $this->app->config['path.content'].$request->getPathInfo(),
		));
	}
}
