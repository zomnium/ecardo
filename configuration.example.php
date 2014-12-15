<?php

/**
 * Ecardo - Easy to use e-card sender
 * @author      Tim van Bergenhenegouwen
 * @link        http://o-utrecht.nl/
 * @copyright   2014 O-utrecht, Tim van Bergenhenegouwen
 */

$config = array(

    // Path

    'path.base'             => __DIR__,
    'path.content'          => __DIR__.'/content',

    // Content

    'content' => array(
        'acme-classname'    => '\ACME\Classname',
        'hello-world'       => '\Hello\World',
    ),

    // Framework

    'framework' => array(
        'debug'             => true,
    ),

    // Mail

    'mail' => array(
        'host' => '127.0.0.1',
        'port' => '25',
        'username' => '',
        'password' => '',
        'encryption' => null,
        'auth_mode' => null,
    ),

);
