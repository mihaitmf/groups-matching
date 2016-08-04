<?php

namespace GroupsMatching;

class Matcher
{
    /** @var SubsetsGenerator */
    private $subsetsGenerator;

    public function __construct(SubsetsGenerator $subsetsGenerator)
    {
        $this->subsetsGenerator = $subsetsGenerator;
    }

    /**
     * @param int[][] $preferencesMatrix
     * @param int[] $groupSizes
     */
    public function run(array $preferencesMatrix, array $groupSizes)
    {
        $this->validateInputParams($preferencesMatrix, $groupSizes);

        $triangularMatrix = $this->reduceToTriangularMatrix($preferencesMatrix);

        $numberOfElements = count($preferencesMatrix);

        for ($i = 0; $i < $numberOfElements; $i++) {
            for ($j = 0; $j < $numberOfElements; $j++) {
                print($triangularMatrix[$i][$j] . "\t");
            }
            print("\n");
        }




        $allElements = range(0, $numberOfElements - 1);
        $groupSize = $groupSizes[0];
        $subsets = $this->subsetsGenerator->generateSubsets($allElements, $groupSize);

        var_dump($subsets);

        $matches = [];
        foreach ($subsets as $key => $subset) {
            $remainingSubset = array_values(array_diff($allElements, $subset));

            $groups = [
                new Group($subset, $this->calculateGroupValue($subset, $triangularMatrix)),
                new Group($remainingSubset, $this->calculateGroupValue($remainingSubset, $triangularMatrix)),
            ];
            $matches[] = new Match($groups, 0);
        }

        var_dump($matches);


        $this->generateGroups($allElements, 0, $groupSizes, $triangularMatrix);
    }

    private function generateGroups(array $elements, $groupIndex, array $groupSizes, array $triangularMatrix)
    {
        $maxGroupIndex = count($groupSizes) - 1;

        $groupSize = $groupSizes[$groupIndex];
        $subsets = $this->subsetsGenerator->generateSubsets($elements, $groupSize);

        foreach ($subsets as $key => $subset) {

            $groups = [
                new Group($subset, $this->calculateGroupValue($subset, $triangularMatrix)),
            ];

            $remainingSubset = array_values(array_diff($elements, $subset));

            if ($groupIndex != $maxGroupIndex && count($remainingSubset) > $groupSizes[$groupIndex + 1]) {
                $groups[] = $this->generateGroups($remainingSubset, $groupIndex + 1, $groupSizes, $triangularMatrix);
            }

        }
    }

    /**
     * @param array $subset
     * @param array $triangularMatrix
     * @return int
     */
    private function calculateGroupValue(array $subset, $triangularMatrix)
    {
        $sum = 0;
        for ($i = 0; $i < count($subset) - 1; $i++) {
            for ($j = $i + 1; $j < count($subset); $j++) {
                $sum += $triangularMatrix[$subset[$i]][$subset[$j]];
            }
        }

        return $sum;
    }

    /**
     * @param array $preferencesMatrix
     * @return array
     */
    private function reduceToTriangularMatrix(array $preferencesMatrix)
    {
        $triangularMatrix = [];
        $numberOfElements = count($preferencesMatrix);
        for ($i = 0; $i < $numberOfElements; $i++) {
            $triangularMatrix[$i] = array_fill(0, $numberOfElements, 0);
        }

        for ($i = 0; $i < $numberOfElements - 1; $i++) {
            for ($j = $i + 1; $j < $numberOfElements; $j++) {
                $triangularMatrix[$i][$j] = ($preferencesMatrix[$i][$j] + $preferencesMatrix[$j][$i]) / 2;
            }
        }

        return $triangularMatrix;
    }

    /**
     * @param array $preferencesMatrix
     * @param array $groupSizes
     * @throws \Exception
     */
    private function validateInputParams(array $preferencesMatrix, array $groupSizes)
    {
        $numberOfElements = count($preferencesMatrix);

        $sum = 0;
        foreach ($groupSizes as $size) {
            $sum += $size;
        }
        if ($sum != $numberOfElements) {
            throw new \Exception('Group sizes sum is different than the size of the preferences matrix');
        }

        foreach ($preferencesMatrix as $row) {
            if (count($row) != $numberOfElements) {
                throw new \Exception('Column size different than row size in the preferences matrix');
            }
        }
    }
}
