<?php
class BucketTest extends PHPUnit_Framework_TestCase
{
    public function validValuesProvider()
    {
        return array(
            array(3,5,4),
            array(2,6,4),
            array(2,4,4),
            array(4,6,4),
            array(3,7,4),
            array(3,15,9),
            array(5,8,7)
        );
    }
    public function invalidValuesProvider()
    {
        return array(
            array(3,5,'shennanigans'),
            array(2,-4,6),
            array(3,'',4),
            array(3,15,7),
            array(2,8,7),
            array(2,4,6),
            array(4,8,2)
        );

    }
}