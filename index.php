<?php

/**
 * Ecardo - Easy to use e-card sender
 * @author      Tim van Bergenhenegouwen
 * @link        http://o-utrecht.nl/
 * @copyright   2014 O-utrecht, Tim van Bergenhenegouwen
 */

/**
 * Configuration
 */

require 'configuration.php';

/**
 * Autoload
 */

require 'vendor/autoload.php';

/**
 * Bootstrap
 */

$app = new \Ecardo\App($config);
