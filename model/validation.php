<?php

/*
 * 328/dating/model/validation.php
 * Phillip Ball
 * 05/15/2021
 * This file holds validation functions for my dating project
*/

class Validation
{
    // methods
    // checks to see that a string is all alphabetic
    static function validName($name)
    {
        return ctype_alpha(trim($name));
    }

    // checks to see that an age is numeric and between 18 and 118
    static function validAge($age)
    {
        return $age > 18 && $age < 118;
    }

    // checks to see that a phone number is valid (you can decide what constitutes a “valid” phone number)
    static function validPhone($phone)
    {
        return strlen($phone) == 10 && is_numeric($phone);
    }

    // checks to see that an email address is valid
    static function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // checks each selected outdoor interest against a list of valid options
    static function validOutdoor($outdoor)
    {
        // loop through to check each interest
        foreach ($outdoor as $interest) {
            // if something that is not part of the dataLayer array, return false
            if (!in_array($interest, DataLayer::getOutdoorBoxes())) {
                return false;
            }
        }
        return true;
    }

    // checks each selected indoor interest against a list of valid options
    static function validIndoor($indoor)
    {
        // loop through to check each interest
        foreach ($indoor as $interest) {
            // if something that is not part of the dataLayer array, return false
            if (!in_array($interest, DataLayer::getIndoorBoxes())) {
                return false;
            }
        }
        return true;
    }
}