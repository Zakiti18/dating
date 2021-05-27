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
    // fields
    private $_f3; // router

    // methods
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
        // instantiate a user object
        if(isset($_POST['premium'])){
            $user = new PremiumMember();
        }
        else{
            $user = new Member();
        }

        // if the form has been submitted, add data to session and send user to next form
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // store input into user object
            $user->setFname($_POST['fName']);
            $user->setLname($_POST['lName']);
            $user->setAge($_POST['age']);
            $user->setGender($_POST['gender']);
            $user->setPhone($_POST['phoneNum']);

            // check validation
            // name validation
            if(!Validation::validName($_POST['fName']) && !Validation::validName($_POST['lName'])) {
                $this->_f3->set('errors["name"]', 'Both first and last names are required');
            }

            // age validation
            if(!Validation::validAge($_POST['age'])) {
                $this->_f3->set('errors["age"]', 'Age is required and must be between 18 and 118');
            }

            // phone number validation
            if(!Validation::validPhone($_POST['phoneNum'])) {
                $this->_f3->set('errors["phone"]', 'Phone number is required and is entered like the example "1234567890"');
            }

            // store user object into the session
            $_SESSION['user'] = $user;

            // if the error array is empty, redirect to next page
            if(empty($this->_f3->get('errors'))) {
                header('location: profile');
            }
        }

        // set user input into the hive for form stickyness
        $this->_f3->set("userFName", $user->getFname());
        $this->_f3->set("userLName", $user->getLname());
        $this->_f3->set("userAge", $user->getAge());
        $this->_f3->set("userGender", $user->getGender());
        $this->_f3->set("userPhone", $user->getPhone());
        $this->_f3->set("premiumUser", $_POST['premium']);

        // display the form part 1 "Personal Information"
        $view = new Template();
        echo $view->render('views/personalInfo.html');
    }

    function profile()
    {
        // initialize variables to store user input for sticky forms
        $user = $_SESSION['user'];
        $user->setEmail("");
        $user->setState("");
        $user->setSeeking("");
        $user->setBio("");

        // if the form has been submitted, add data to session and send user to next form
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // actually store user input
            $user->setEmail($_POST['email']);
            $user->setState($_POST['state']);
            $user->setSeeking($_POST['seeking']);
            $user->setBio($_POST['bio']);

            // check email validation
            if(!Validation::validEmail($_POST['email'])) {
                $this->_f3->set('errors["email"]', 'Email is required');
            }

            // if the error array is empty, redirect to next page
            if(empty($this->_f3->get('errors'))) {
                // if the user is a PremiumMember send them to interests page
                if($user instanceof PremiumMember){
                    header('location: interests');
                }
                // otherwise, send them to the summary
                else{
                    header('location: summary');
                }
            }
        }

        // store user input into the hive
        $this->_f3->set("userEmail", $user->getEmail());
        $this->_f3->set("userState", $user->getState());
        $this->_f3->set("userSeeking", $user->getSeeking());
        $this->_f3->set("userBio", $user->getBio());

        // display the form part 2 "Profile"
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    function interests()
    {
        $user = $_SESSION['user'];

        // if the form has been submitted, add data to session and send user to the summary
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user->setInDoorInterests($_POST['indoorInterests']);
            $user->setOutDoorInterests($_POST['outdoorInterests']);

            // validate interests in case of spoofs, is okay if empty though
            // in door interests
            if(!empty($_POST['indoorInterests'])) {
                if(!Validation::validIndoor($_POST['indoorInterests'])){
                    $this->_f3->set('errors["spoof"]', 'Cheater!');
                }
            }

            // out door interests
            if(!empty($_POST['outdoorInterests'])) {
                if(!Validation::validOutdoor($_POST['outdoorInterests'])){
                    $this->_f3->set('errors["spoof"]', 'Cheater!');
                }
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