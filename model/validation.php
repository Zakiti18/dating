<?php

/**
 * Class Validation
 * 328/dating/model/validation.php
 * Phillip Ball
 * 05/15/2021
 *
 * This file holds validation functions for my dating project
*/
class Validation
{
    // methods
    /**
     * Checks to see that a string is all alphabetic.
     *
     * @param $name - A String
     * @return bool - true if the name is only alphabetic characters, false otherwise
     */
    static function validName($name)
    {
        return ctype_alpha(trim($name));
    }

    /**
     * Checks to see that an age is numeric and between 18 and 118.
     *
     * @param $age - A int
     * @return bool - true if the age is between 18 and 118 exclusive, false otherwise
     */
    static function validAge($age)
    {
        return $age > 18 && $age < 118;
    }

    /**
     * checks to see that a phone number is valid
     * (you can decide what constitutes a “valid” phone number).
     *
     * @param $phone - A String of numbers
     * @return bool - true if phone is 10 numeric characters, false otherwise
     */
    static function validPhone($phone)
    {
        return strlen($phone) == 10 && is_numeric($phone);
    }

    /**
     * checks to see that an email address is valid.
     *
     * @param $email - A String
     * @return mixed - The filtered (validated/true) email, false otherwise
     */
    static function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * checks each selected outdoor interest against a list of valid options.
     *
     * @param $outdoor - An array of Strings
     * @return bool - true if no String was spoofed, false otherwise
     */
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

    /**
     * checks each selected indoor interest against a list of valid options.
     *
     * @param $indoor - An array of Strings
     * @return bool - true if no String was spoofed, false otherwise
     */
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