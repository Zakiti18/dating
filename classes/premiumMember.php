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
    private $_inDoorInterests = array();
    private $_outDoorInterests = array();

    // methods
    /**
     * @return array of Strings
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param array $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return array of Strings
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param array $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }
}