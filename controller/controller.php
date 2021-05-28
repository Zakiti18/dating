<?php

/**
 * Class Controller
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
    /**
     * Controller constructor.
     *
     * @param $f3 - Fat-Free router
     */
    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /**
     * Template for the home page.
     */
    function home()
    {
        // Add userQuotes to the hive
        $this->_f3->set("userQuotes", DataLayer::getUserQuotes());

        // display the home page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Template for the personalInfo page (part 1 of the sign up form).
     */
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

    /**
     * Template for the profile page (part 2 of the sign up form).
     */
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

            // allowing the option of adding a profile image (only for PremiumMembers)
            if (!empty($_FILES['fileToUpload']['name'])) {
                // building the image location
                $target_dir = "images/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $this->_f3->set('errors["image"]', 'Sorry, file already exists.');
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $this->_f3->set('errors["image"]', 'Sorry, your file is too large.');
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $this->_f3->set('errors["image"]', 'Sorry, only JPG, JPEG, PNG files are allowed.');
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $this->_f3->set('errors["image"]', 'Sorry, your file was not uploaded.');
                    // if everything is ok, try to upload file
                } else {
                    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $this->_f3->set('errors["image"]', 'Sorry, there was an error uploading your file.');
                    }
                }

                // add the image location to the user object
                $user->setProfileImage($target_file);
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

    /**
     * Template for the interests page (part 3 of the sign up form).
     * This page is only viewed by PremiumMembers.
     */
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

    /**
     * Template for the summary page (final part of the sign up form).
     * Only displays interests for PremiumMembers.
     */
    function summary()
    {
        // display the form summary
        $view = new Template();
        echo $view->render('views/summary.html');
    }
}