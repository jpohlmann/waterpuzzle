<?php
require('Bucket.php');
require('Validator.php');
class BucketFactory
{
    /**
     * Solves the problem in the least number of steps possible, given the 2 buckets.
     *
     * @param Bucket  $bucket1 Bucket 1
     * @param Bucket  $bucket2 Bucket 2
     * @param integer $target  Target value
     */
    public function solveProblem(
        Bucket $bucket1,
        Bucket $bucket2,
        $target
    ) {
        $validator   = new Validator(
            $bucket1->getCapacity(),
            $bucket2->getCapacity(),
            $target
        );
        $validator->validate();
        $bucket1Array = $this->generateSolution(
            $bucket1,
            $bucket2,
            $target
        );
        $this->emptyBucket($bucket1);
        $this->emptyBucket($bucket2);
        $bucket2Array = $this->generateSolution(
            $bucket2,
            $bucket1,
            $target
        );
        if (sizeof($bucket1Array) > sizeof($bucket2Array)) {
            return $bucket2Array;
        }
        return $bucket1Array;
    }

    /**
     * Generates the solution for the given buckets in the given order.
     *
     * @param Bucket  $bucket1 Bucket 1
     * @param Bucket  $bucket2 Bucket 2
     * @param integer $target  Target value
     */
    public function generateSolution(Bucket $bucket1, Bucket $bucket2, $target)
    {
        $solutionSteps = array();
        while (($bucket1->getCurrent() != $target)
            && ($bucket2->getCurrent() != $target)
        ) {

            if ($bucket1->isFull() && ($bucket1->getCurrent() != $target)) {
                $this->emptyBucket($bucket1);
            } elseif ($bucket2->isEmpty()) {
                $this->fillBucket($bucket2);
            } else {
                $this->pour($bucket2, $bucket1);
            }
            $solutionStep = array(
                $bucket1->getOrder() => $bucket1->getCurrent(),
                $bucket2->getOrder() => $bucket2->getCurrent()
            );
            if ($this->checkForRepeats($solutionStep, $solutionSteps)) {
                throw new ValidationException("It doesn't look like there's a solution that exists.");
            }
            $solutionSteps[] = $solutionStep;
        }
        return $solutionSteps;
    }

    /**
     * Pour one bucket into the other bucket
     *
     * @param Bucket $bucket1
     * @param Bucket $bucket2
     */
    public function pour(Bucket $bucket1, Bucket $bucket2)
    {
        if ($bucket1->getCurrent() > $bucket2->getSpaceLeft()) {
            $pouredAmount = $bucket2->getSpaceLeft();
        } else {
            $pouredAmount = $bucket1->getCurrent();
        }
        $bucket1->setCurrent($bucket1->getCurrent() - $pouredAmount);
        $bucket2->setCurrent($bucket2->getCurrent() + $pouredAmount);
    }

    /**
     * Empty bucket
     *
     * @param Bucket $bucket
     *
     * @return void
     */
    public function emptyBucket(Bucket $bucket)
    {
        $bucket->setCurrent(0);
    }

    /**
     * Fill bucket
     *
     * @param Bucket $bucket
     *
     * @return void
     */
    public function fillBucket(Bucket $bucket)
    {
        $bucket->setCurrent($bucket->getCapacity());
    }

    /**
     * Get all 2 number combinations given a max number
     *
     * @param integer $numberOfBuckets
     *
     * @return array all combinations
     */
    public static function getCombinations($numberOfBuckets)
    {
        $combinations = array();
        for ($x=1; $x<=$numberOfBuckets; $x++) {
            for ($y=1; $y<=$numberOfBuckets; $y++) {
                if (($x!=$y)
                    && (!in_array(array(min($x,$y), max($x,$y)), $combinations))
                ) {
                    $combinations[] = array(min($x,$y), max($x,$y));
                }
            }
        }
        return $combinations;
    }

    /**
     * Checks if a value repeats
     *
     * @param array $value         Value
     * @param array $solutionArray Solution Array
     *
     * @return boolean True if repeats
     */
    public function checkForRepeats($value, $solutionArray) {
        if (!in_array($value, $solutionArray)) {
            return false;
        }
        return true;
    }
}