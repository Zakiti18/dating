<?php
/*
 * 328/dating/index.php
 * Phillip Ball
 * 04/21/2021
 *
 * This file controls which page the user is routed to for the Dating assignment
 * Additional work began on 04/27/2021 for Dating 2
 * Additional work began on 05/15/2021 for Dating 3
 * Additional work began on 05/26/2021 for Dating 4
*/

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require needed files
require_once('vendor/autoload.php');

// start a session
session_start();

// instantiate Fat-Free and controller
$f3 = Base::instance();
$con = new Controller($f3);

// define routes
// default (home) route
$f3->route('GET /', function (){
    $GLOBALS["con"]->home();
});

// part 1 of the create a profile form
$f3->route('GET|POST /personalInfo', function (){
    $GLOBALS["con"]->personalInfo();
});

// part 2 of the create a profile form
$f3->route('GET|POST /profile', function (){
    $GLOBALS["con"]->profile();
});

// part 3 of the create a profile form
$f3->route('GET|POST /interests', function (){
    $GLOBALS["con"]->interests();
});

// summary of entered info from form
$f3->route('GET /summary', function (){
    $GLOBALS["con"]->summary();
});

// run Fat-Free
$f3->run();