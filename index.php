<?php
/*
 * Phillip Ball
 * 04/21/2021
 * This is my controller for the Dating 1 assignment
*/

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require autoload file
require_once('vendor/autoload.php');

// instantiate Fat-Free
$f3 = Base::instance();

// define routes
// default route
$f3->route('GET /', function (){
    // display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// run Fat-Free
$f3->run();