<?php
require('../Classes/BucketFactory.php');
require('BucketTest.php');
class BucketFactoryTest extends BucketTest
{
    /**
     * Tests that all valid values properly return solutions
     *
     * @param string $smallBucket The value to test
     * @param string $bigBucket The value to test
     * @param string $target The value to test
     *
     * @test
     * @dataProvider validValuesProvider
     *
     * @return void
     */
    public function validValuesReturnSolutions($smallBucket, $bigBucket, $target)
    {
        $bucketFactory = new BucketFactory();
        $result        = $bucketFactory->solveProblem(
            new Bucket($smallBucket, 1),
            new Bucket($bigBucket, 2),
            $target
        );
        $this->assertNotEmpty($result);
        $finalValue = array_pop($result);
        $this->assertArrayHasKey('1', $finalValue);
        $this->assertArrayHasKey('2', $finalValue);
        $oneValueMatchesTarget = (
            ($finalValue['1'] == $target)
            || ($finalValue['2'] == $target)
        );
        $this->assertTrue($oneValueMatchesTarget);
    }

    /**
     * Tests that all invalid values properly are flagged
     *
     * @param string $smallBucket The value to test
     * @param string $bigBucket The value to test
     * @param string $target The value to test
     *
     * @test
     * @dataProvider invalidValuesProvider
     * @expectedException ValidationException
     *
     * @return void
     */
    public function invalidValuesFlaggedByValidator(
        $smallBucket,
        $bigBucket,
        $target
    ) {
        $bucketFactory = new BucketFactory();
        $result        = $bucketFactory->solveProblem(
            new Bucket($smallBucket, 1),
            new Bucket($bigBucket, 2),
            $target
        );
    }
    /**
     * Tests that repeats are successfully found
     *
     * @test
     *
     * @return void
     */
    public function checkForRepeatsTest()
    {
        $bucketFactory = new BucketFactory();
        $solutionArray = array(
            array('1' => 5, '2' => 6),
            array('1' => 7, '2' => 3)
        );
        $solution = array('1' => 7, '2' => 3);
        $this->assertTrue($bucketFactory->checkForRepeats($solution, $solutionArray));
    }
}

