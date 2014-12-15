<?php

/**
 * Ecardo - Easy to use e-card sender
 * @author      Tim van Bergenhenegouwen
 * @link        http://o-utrecht.nl/
 * @copyright   2014 O-utrecht, Tim van Bergenhenegouwen
 */

namespace Ecardo;

use \Silex\Application as SilexApplication;
use \Symfony\Component\HttpFoundation\Request;

class App
{
    private static $instance;
    public $silex;
    public $config;
    public $ecards;

    /**
     * Bootstrap
     *
     * @param array $config Application configuration
     */

    public function __construct(Array $config)
    {
        // Create singleton instance
        self::$instance = $this;

        // Set configuration
        $this->setConfiguration($config);

        // Register framework
        $this->silex = new SilexApplication($this->config['framework']);

        // Index ecards
        $this->indexEcards($this->config['content']);

        // Error pages
        // $this->silex->error(array($this, 'errorPage'));

        // Run application
        $this->silex->run();
    }

    /**
     * Get singleton instance of this class
     *
     * @return object Singleton of this instance
     */

    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Default Configuration
     *
     * @return array
     */

    private function defaultConfiguration()
    {
        return array(
            'framework' => array(
                'debug' => false,
                ),
            );
    }

    /**
     * Set Configuration
     * 
     * @param array $config Application configuration to overwrite defaults
     * @return array
     */

    private function setConfiguration(Array $config)
    {
        // Merge default configuration with input
        return $this->config = array_merge_recursive($config, $this->defaultConfiguration());
    }

    /**
     * Index Ecards
     *
     * @param array $ecards Ecards with machinename as key and class as value
     */

    private function indexEcards($ecards)
    {
        // Loop through content
        foreach ($ecards as $name => $class)
        {
            // Load ecard
            $this->loadEcard($name, $class);
        }
    }

    /**
     * Load Ecard
     * 
     * @param string $name Machinename of the ecard
     * @param string $class Class of the ecard
     * @return object on succes or else boolean false
     */

    private function loadEcard($name, $class)
    {
        // Generate filepath
        $filepath = $this->config['path.content'].'/'.$name.'/ecard.php';

        // File does not exist, quit
        if (! file_exists($filepath))
            return false;

        // Get file
        require $filepath;

        // Class does not exists, quit
        if (! class_exists($class))
            return false;

        // Load ecard
        return $this->ecards[$name] = new $class;
   }

   /**
    * Error Page
    * TODO: implement this
    */

   public function errorPage() {}
}
