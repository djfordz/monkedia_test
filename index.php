<?php

use Monkedia\Test\App;
//
// load composer autoloader
if (file_exists('vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    echo 'Error! Please install composer and run composer install';
    exit;
}

// start application
$app = new App();
