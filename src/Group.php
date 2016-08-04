<?php

namespace GroupsMatching;

class Group
{
    private $elements;
    private $groupCohesionValue;

    public function __construct(array $elements, $groupCohesionValue)
    {
        $this->elements = $elements;
        $this->groupCohesionValue = $groupCohesionValue;
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return float
     */
    public function getGroupCohesionValue()
    {
        return $this->groupCohesionValue;
    }
}
