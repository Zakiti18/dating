<?php

/**
 * Class Member
 * 328/dating/classes/member.php
 * Phillip Ball
 * 05/26/2021
 *
 * This file is used to store users input as an object
*/
class Member
{
    // fields
    private $_fname; // String
    private $_lname; // String
    private $_age; // int
    private $_gender; // String
    private $_phone; // String
    private $_email; // String
    private $_state; // String
    private $_seeking; // String
    private $_bio; // String

    // methods
    /**
     * Member constructor.
     * Initializes parameters to empty strings to help make the form sticky.
     *
     * @param $_fname - String
     * @param $_lname - String
     * @param $_age - int
     * @param $_gender - String
     * @param $_phone - String
     */
    public function __construct($_fname="", $_lname="", $_age="", $_gender="", $_phone="")
    {
        $this->_fname = $_fname;
        $this->_lname = $_lname;
        $this->_age = $_age;
        $this->_gender = $_gender;
        $this->_phone = $_phone;
    }

    /**
     * Returns the Members first name.
     *
     * @return mixed String
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * Sets the Members first name.
     *
     * @param mixed $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * Returns the Members last name.
     *
     * @return mixed String
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * Sets the Members last name.
     *
     * @param mixed $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * Returns the Members age.
     *
     * @return mixed int
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Sets the Members age.
     *
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Returns the Members gender.
     *
     * @return mixed String
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Sets the Members gender.
     *
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Returns the Members phone number.
     *
     * @return mixed String
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets the Members phone number.
     *
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Returns the Members email.
     *
     * @return mixed String
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the Members email.
     *
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Returns the Members state.
     *
     * @return mixed String
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets the Members state.
     *
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * Returns the gender that the Member is seeking.
     *
     * @return mixed String
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * Sets the gender that the Member is seeking.
     *
     * @param mixed $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * Returns the Members biography.
     *
     * @return mixed String
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * Sets the Members biography.
     *
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }
}