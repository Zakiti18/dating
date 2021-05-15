<?php
/*
 * 328/dating/index.php
 * Phillip Ball
 * 04/21/2021
 * This is my controller for the Dating 1 assignment
 * Additional work began on 04/27/2021 for Dating 2
 * Additional work began on 05/15/2021 for Dating 3
*/

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

// require needed files
require_once('vendor/autoload.php');
require_once('model/validation.php');
require_once('model/dataLayer.php');

// instantiate Fat-Free
$f3 = Base::instance();

// define routes
// default (home) route
$f3->route('GET /', function ($f3){
    // Add userQuotes to the hive
    $f3->set("userQuotes", getUserQuotes());

    // display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// part 1 of the create a profile form
$f3->route('GET|POST /personalInfo', function (){
    // if the form has been submitted, add data to session
    // and send user to next form
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_SESSION['fName'] = $_POST['fName']; // required
        $_SESSION['lName'] = $_POST['lName']; // required
        $_SESSION['age'] = $_POST['age']; // required
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['phoneNum'] = $_POST['phoneNum']; // required
        header('location: profile');
    }

    // display the form part 1 "Personal Information"
    $view = new Template();
    echo $view->render('views/personalInfo.html');
});

// part 2 of the create a profile form
$f3->route('GET|POST /profile', function (){
    // if the form has been submitted, add data to session
    // and send user to next form
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_SESSION['email'] = $_POST['email']; // required
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['bio'] = $_POST['bio'];
        header('location: interests');
    }

    // display the form part 2 "Profile"
    $view = new Template();
    echo $view->render('views/profile.html');
});

// part 3 of the create a profile form
$f3->route('GET|POST /interests', function ($f3){
    // if the form has been submitted, add data to session and send user to the summary
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['interest'])){
            $_SESSION['interest'] = implode(' ', $_POST['interest']);
        }
        else{
            $_SESSION['interest'] = "You did not choose any interests";
        }
        header('location: summary');
    }

    // Add indoorBoxes and outdoorBoxes to the hive
    $f3->set("indoorBoxes", getIndoorBoxes());
    $f3->set("outdoorBoxes", getOutdoorBoxes());

    // display the form part 3 "Interests"
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