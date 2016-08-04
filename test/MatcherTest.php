<?php

namespace GroupsMatching;

use DI\ContainerBuilder;

class MatcherTest extends \PHPUnit_Framework_TestCase
{
    /** @var Matcher */
    private $matcher;

    protected function setUp()
    {
        $this->matcher = ContainerBuilder::buildDevContainer()->get(Matcher::class);
    }

    public function testMatcher()
    {
        $preferencesMatrix = [
            0 => [0, 5, 1, 3, 1],
            1 => [3, 0, 1, 5, 1],
            2 => [1, 1, 0, 1, 5],
            3 => [1, 5, 1, 0, 1],
            4 => [1, 1, 3, 1, 0],
        ];

        $groupsSizes = [3, 2];

        $this->matcher->run($preferencesMatrix, $groupsSizes);

        self::assertTrue(true);
    }
}
