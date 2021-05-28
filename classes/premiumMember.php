<?php

/**
 * Class PremiumMember
 * 328/dating/classes/premiumMember.php
 * Phillip Ball
 * 05/26/2021
 *
 * This file is a child class of 328/dating/classes/member.php
*/
class PremiumMember extends Member
{
    // fields
    private $_inDoorInterests;
    private $_outDoorInterests;
    private $_profileImage;

    // methods
    /**
     * Returns the PremiumMembers indoor interests.
     *
     * @return array of Strings
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * Sets the PremiumMembers indoor interests.
     *
     * @param array $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * Returns the PremiumMembers outdoor interests.
     *
     * @return array of Strings
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Sets the PremiumMembers outdoor interests.
     *
     * @param array $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }

    /**
     * Returns the PremiumMembers profile image location.
     *
     * @return string
     */
    public function getProfileImage()
    {
        return $this->_profileImage;
    }

    /**
     * Sets the PremiumMembers profile image location.
     *
     * @param string $profileImage
     */
    public function setProfileImage($profileImage)
    {
        $this->_profileImage = $profileImage;
    }
}