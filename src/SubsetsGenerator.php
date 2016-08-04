<?php

namespace GroupsMatching;

class SubsetsGenerator
{
    private $foundSubsets = [];

    /**
     * @param array $setOfValues
     * @param int $subsetSize
     * @return array
     */
    public function generateSubsets(array $setOfValues, $subsetSize)
    {
        $this->foundSubsets = [];
        $this->generateSubsetsOfSize($setOfValues, $subsetSize, 0, 0, []);

        return $this->foundSubsets;
    }

    /**
     * @param array $setOfValues
     * @param int $subsetSize
     * @param int $index
     * @param int $currentNumberOfSelected
     * @param array $selected
     */
    private function generateSubsetsOfSize(
        array $setOfValues,
        $subsetSize,
        $index,
        $currentNumberOfSelected,
        array $selected
    ) {
        if ($currentNumberOfSelected == $subsetSize) {
            $subset = [];
            foreach ($selected as $key => $value) {
                if ($value == 1) {
                    $subset[] = $setOfValues[$key];
                }
            }
            $this->foundSubsets[] = $subset;

            return;
        }

        if ($index == count($setOfValues)) {
            return;
        }

        $selected[$index] = 1;
        $this->generateSubsetsOfSize($setOfValues, $subsetSize, $index + 1, $currentNumberOfSelected + 1, $selected);

        $selected[$index] = 0;
        $this->generateSubsetsOfSize($setOfValues, $subsetSize, $index + 1, $currentNumberOfSelected, $selected);

        return;
    }
}
