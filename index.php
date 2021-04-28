<?php
/*
 * Phillip Ball
 * 04/21/2021
 * This is my controller for the Dating 1 assignment
 * Additional work began on 04/27/2021 for Dating 2
*/

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require autoload file
require_once('vendor/autoload.php');

// instantiate Fat-Free
$f3 = Base::instance();

// define routes
// default (home) route
$f3->route('GET /', function (){
    // display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// part 1 of the create a profile form
$f3->route('GET /personalInfo', function (){
    // display the form part 1 "Personal Information"
    $view = new Template();
    echo $view->render('views/personalInfo.html');
});

// part 2 of the create a profile form
$f3->route('GET /profile', function (){
    // display the form part 1 "Profile"
    $view = new Template();
    echo $view->render('views/profile.html');
});

// part 3 of the create a profile form
$f3->route('GET /interests', function (){
    // display the form part 1 "Interests"
    $view = new Template();
    echo $view->render('views/interests.html');
});

// summary of entered info from form
$f3->route('GET /summary', function (){
    // display the form summary
    $view = new Template();
    echo $view->render('views/summary.html');
});

// run Fat-Free
$f3->run();