<?php

namespace GroupsMatching;

class Match
{
    private $groups;
    private $matchingValue;

    public function __construct($groups, $matchingValue)
    {
        $this->groups = $groups;
        $this->matchingValue = $matchingValue;
    }

    /**
     * @return Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return float
     */
    public function getMatchingValue()
    {
        return $this->matchingValue;
    }
}
