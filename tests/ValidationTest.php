<?php
require('../Classes/Validator.php');
require('BucketTest.php');
class ValidationTest extends BucketTest
{
    /**
     * Tests that all invalid values are properly flagged
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
    public function invalidValuesFlagged($smallBucket, $bigBucket, $target)
    {
        $validator = new Validator($smallBucket, $bigBucket, $target);
        $validator->validate();
    }
    /**
     * Tests that all valid values make it through the validator
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
    public function validValuesOk($smallBucket, $bigBucket, $target)
    {
        $validator = new Validator($smallBucket, $bigBucket, $target);
        $this->assertTrue($validator->validate());
    }
}