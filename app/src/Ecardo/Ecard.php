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

	public function __construct($name, $controller)
	{
		// Get singleton instance of the application
		$this->app = Application::getInstance();

		// Register service providers
		$this->app->silex->register(new \Silex\Provider\FormServiceProvider());
		$this->app->silex->register(new \Silex\Provider\ValidatorServiceProvider());
		$this->app->silex->register(new \Silex\Provider\TranslationServiceProvider(), array(
		    'translator.domains' => array(),
		));

		// Register route and twig service provider
		$this->app->silex->match('/'.$name, $controller)
			 ->before(array($this, 'registerTwigServiceProvider'));
	}

	public function registerTwigServiceProvider(Request $request)
	{
		$this->app->silex->register(new \Silex\Provider\TwigServiceProvider(), array(
			'twig.path' => $this->app->config['path.content'].$request->getPathInfo(),
		));
	}
}
