<?php

namespace GroupsMatching;

class SubsetsGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var SubsetsGenerator */
    private $subsetsGenerator;

    protected function setUp()
    {
        $this->subsetsGenerator = new SubsetsGenerator();
    }

    public function testGenerateSubsets()
    {
        $items = ['A', 'B', 'C', 'D', 'E'];
        $subsetSize = 3;

        $expectedSubsets = [
            ['A', 'B', 'C'],
            ['A', 'B', 'D'],
            ['A', 'B', 'E'],
            ['A', 'C', 'D'],
            ['A', 'C', 'E'],
            ['A', 'D', 'E'],
            ['B', 'C', 'D'],
            ['B', 'C', 'E'],
            ['B', 'D', 'E'],
            ['C', 'D', 'E'],
        ];

        $subsets = $this->subsetsGenerator->generateSubsets($items, $subsetSize);

        $this->assertEquals($expectedSubsets, $subsets);
    }
}
