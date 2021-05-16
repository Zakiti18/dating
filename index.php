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
$f3->route('GET|POST /personalInfo', function ($f3){
    // initialize variables to store user input for sticky forms
    $userFName = "";
    $userLName = "";
    $userAge = "";
    $userGender = "";
    $userPhone = "";

    // if the form has been submitted, add data to session and send user to next form
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // actually store user input
        $userFName = $_POST['fName'];
        $userLName = $_POST['lName'];
        $userAge = $_POST['age'];
        $userGender = $_POST['gender'];
        $userPhone = $_POST['phoneNum'];

        // check validation
        // name validation
        if(validName($_POST['fName']) && validName($_POST['lName'])) {
            $_SESSION['fName'] = $_POST['fName']; // required
            $_SESSION['lName'] = $_POST['lName']; // required
        }
        else{
            $f3->set('errors["name"]', 'Both first and last names are required');
        }

        // age validation
        if(validAge($_POST['age'])) {
            $_SESSION['age'] = $_POST['age']; // required
        }
        else{
            $f3->set('errors["age"]', 'Age is required and must be between 18 and 118');
        }

        $_SESSION['gender'] = $_POST['gender'];

        // phone number validation
        if(validPhone($_POST['phoneNum'])) {
            $_SESSION['phoneNum'] = $_POST['phoneNum']; // required
        }
        else{
            $f3->set('errors["phone"]', 'Phone number is required and is entered like the example "1234567890"');
        }

        // if the error array is empty, redirect to next page
        if(empty($f3->get('errors'))) {
            header('location: profile');
        }
    }

    // store user input into the hive
    $f3->set("userFName", $userFName);
    $f3->set("userLName", $userLName);
    $f3->set("userAge", $userAge);
    $f3->set("userGender", $userGender);
    $f3->set("userPhone", $userPhone);

    // display the form part 1 "Personal Information"
    $view = new Template();
    echo $view->render('views/personalInfo.html');
});

// part 2 of the create a profile form
$f3->route('GET|POST /profile', function ($f3){
    // initialize variables to store user input for sticky forms
    $userEmail = "";
    $userState = "";
    $userSeeking = "";
    $userBio = "";

    // if the form has been submitted, add data to session and send user to next form
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // actually store user input
        $userEmail = $_POST['email'];
        $userState = $_POST['state'];
        $userSeeking = $_POST['seeking'];
        $userBio = $_POST['bio'];

        // check email validation
        if(validEmail($_POST['email'])) {
            $_SESSION['email'] = $_POST['email']; // required
        }
        else{
            $f3->set('errors["email"]', 'Email is required');
        }

        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['bio'] = $_POST['bio'];

        // if the error array is empty, redirect to next page
        if(empty($f3->get('errors'))) {
            header('location: interests');
        }
    }

    // store user input into the hive
    $f3->set("userEmail", $userEmail);
    $f3->set("userState", $userState);
    $f3->set("userSeeking", $userSeeking);
    $f3->set("userBio", $userBio);

    // display the form part 2 "Profile"
    $view = new Template();
    echo $view->render('views/profile.html');
});

// part 3 of the create a profile form
$f3->route('GET|POST /interests', function ($f3){
    // if the form has been submitted, add data to session and send user to the summary
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // validate interests in case of spoofs, is okay if empty though
        // in door interests
        if(!empty($_POST['indoorInterests'])) {
            if(validIndoor($_POST['indoorInterests'])){
                $_SESSION['indoorInterests'] = implode(' ', $_POST['indoorInterests']);
            }
            else{
                $f3->set('errors["spoof"]', 'Cheater!');
            }
        }
        else{
            $_SESSION['indoorInterests'] = "You did not choose any indoor interests";
        }

        // out door interests
        if(!empty($_POST['outdoorInterests'])) {
            if(validOutdoor($_POST['outdoorInterests'])){
                $_SESSION['outdoorInterests'] = implode(' ', $_POST['outdoorInterests']);
            }
            else{
                $f3->set('errors["spoof"]', 'Cheater!');
            }
        }
        else{
            $_SESSION['outdoorInterests'] = "You did not choose any outdoor interests";
        }

        // if the error array is empty, redirect to next page
        if(empty($f3->get('errors'))) {
            header('location: summary');
        }
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