<?php
/*
 * 328/dating/controller/controller.php
 * Phillip Ball
 * 05/26/2021
 *
 * This is my controller for the Dating assignment
*/

class Controller
{
    private $_f3; // router

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        // Add userQuotes to the hive
        $this->_f3->set("userQuotes", DataLayer::getUserQuotes());

        // display the home page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function personalInfo()
    {
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
            if(Validation::validName($_POST['fName']) && Validation::validName($_POST['lName'])) {
                $_SESSION['fName'] = $_POST['fName']; // required
                $_SESSION['lName'] = $_POST['lName']; // required
            }
            else{
                $this->_f3->set('errors["name"]', 'Both first and last names are required');
            }

            // age validation
            if(Validation::validAge($_POST['age'])) {
                $_SESSION['age'] = $_POST['age']; // required
            }
            else{
                $this->_f3->set('errors["age"]', 'Age is required and must be between 18 and 118');
            }

            $_SESSION['gender'] = $_POST['gender'];

            // phone number validation
            if(Validation::validPhone($_POST['phoneNum'])) {
                $_SESSION['phoneNum'] = $_POST['phoneNum']; // required
            }
            else{
                $this->_f3->set('errors["phone"]', 'Phone number is required and is entered like the example "1234567890"');
            }

            // if the error array is empty, redirect to next page
            if(empty($this->_f3->get('errors'))) {
                header('location: profile');
            }
        }

        // store user input into the hive
        $this->_f3->set("userFName", $userFName);
        $this->_f3->set("userLName", $userLName);
        $this->_f3->set("userAge", $userAge);
        $this->_f3->set("userGender", $userGender);
        $this->_f3->set("userPhone", $userPhone);

        // display the form part 1 "Personal Information"
        $view = new Template();
        echo $view->render('views/personalInfo.html');
    }

    function profile()
    {
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
            if(Validation::validEmail($_POST['email'])) {
                $_SESSION['email'] = $_POST['email']; // required
            }
            else{
                $this->_f3->set('errors["email"]', 'Email is required');
            }

            $_SESSION['state'] = $_POST['state'];
            $_SESSION['seeking'] = $_POST['seeking'];
            $_SESSION['bio'] = $_POST['bio'];

            // if the error array is empty, redirect to next page
            if(empty($this->_f3->get('errors'))) {
                header('location: interests');
            }
        }

        // store user input into the hive
        $this->_f3->set("userEmail", $userEmail);
        $this->_f3->set("userState", $userState);
        $this->_f3->set("userSeeking", $userSeeking);
        $this->_f3->set("userBio", $userBio);

        // display the form part 2 "Profile"
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    function interests()
    {
        // if the form has been submitted, add data to session and send user to the summary
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // validate interests in case of spoofs, is okay if empty though
            // in door interests
            if(!empty($_POST['indoorInterests'])) {
                if(Validation::validIndoor($_POST['indoorInterests'])){
                    $_SESSION['indoorInterests'] = implode(' ', $_POST['indoorInterests']);
                }
                else{
                    $this->_f3->set('errors["spoof"]', 'Cheater!');
                }
            }
            else{
                $_SESSION['indoorInterests'] = "You did not choose any indoor interests";
            }

            // out door interests
            if(!empty($_POST['outdoorInterests'])) {
                if(Validation::validOutdoor($_POST['outdoorInterests'])){
                    $_SESSION['outdoorInterests'] = implode(' ', $_POST['outdoorInterests']);
                }
                else{
                    $this->_f3->set('errors["spoof"]', 'Cheater!');
                }
            }
            else{
                $_SESSION['outdoorInterests'] = "You did not choose any outdoor interests";
            }

            // if the error array is empty, redirect to next page
            if(empty($this->_f3->get('errors'))) {
                header('location: summary');
            }
        }

        // Add indoorBoxes and outdoorBoxes to the hive
        $this->_f3->set("indoorBoxes", DataLayer::getIndoorBoxes());
        $this->_f3->set("outdoorBoxes", DataLayer::getOutdoorBoxes());

        // display the form part 3 "Interests"
        $view = new Template();
        echo $view->render('views/interests.html');
    }

    function summary()
    {
        // display the form summary
        $view = new Template();
        echo $view->render('views/summary.html');
    }
}