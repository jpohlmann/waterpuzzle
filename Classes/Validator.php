<?php
require_once('ValidationException.php');
class Validator
{
    /**
     * Capacity of small bucket
     *
     * @var integer
     */
    protected $smallBucket;

    /**
     * Capacity of big bucket
     *
     * @var integer
     */
    protected $bigBucket;

    /**
     * Capacity of target
     *
     * @var integer
     */
    protected $target;

    /**
     * Construct and set values
     *
     * @param integer $smallBucket
     * @param integer $bigBucket
     * @param integer $target
     */
    public function __construct($smallBucket, $bigBucket, $target)
    {
        $this->smallBucket = $smallBucket;
        $this->bigBucket   = $bigBucket;
        $this->target      = $target;
    }

    /**
     * Validates the values
     *
     * @throws ValidationException
     */
    public function validate()
    {
        if ((!is_numeric($this->smallBucket))
            || (!is_numeric($this->smallBucket))
            || (!is_numeric($this->target))
        ) {
            throw new ValidationException('Values must be numeric.');
        }
        if (!$this->valuesNonNegative(
            $this->smallBucket,
            $this->bigBucket,
            $this->target)
        ) {
            throw new ValidationException(
                'Values cannot be negative.'
            );
        }
        if (!$this->validateEvenOddValues(
            $this->smallBucket,
            $this->bigBucket,
            $this->target)
        ) {
            throw new ValidationException(
                'If the target is odd, the buckets cannot both be even.'
            );
        }
        if (!$this->validateBucketSizes(
            $this->smallBucket,
            $this->bigBucket,
            $this->target)
        ) {
            throw new ValidationException(
                'One of the buckets must be the same size as or larger than target.'
            );
        }
        if (!$this->validateGcd(
            $this->smallBucket,
            $this->bigBucket,
            $this->target)
        ) {
            throw new ValidationException(
                'Greatest common divisor of the buckets must not be bigger'
                .' than the greatest common divisor of the target and the bucket.'
            );
        }
        return true;
    }

    /**
     * Validates that the target is not even and the two values are not odd
     *
     * @return boolean true if passes validation
     */
    public function validateEvenOddValues()
    {
        $bucket1Odd = ($this->smallBucket % 2);
        $bucket2Odd = ($this->bigBucket % 2);
        $this->targetOdd  = ($this->target % 2);
        if (($bucket1Odd == 0) && ($bucket2Odd == 0) && ($this->targetOdd == 1)) {
            return false;
        }
        return true;
    }

    /**
     * Validates that the bucket sizes are not both smaller than the target
     *
     * @return boolean true if passes validation
     */
    public function validateBucketSizes()
    {
        if (($this->smallBucket < $this->target)
            && ($this->bigBucket < $this->target)
        ) {
            return false;
        }
        return true;
    }

    /**
     * Validates that the gcd of the two values are not
     * both bigger than gcd with target.
     *
     * @return boolean true if passes validation
     */
    public function validateGcd()
    {
        $minTargetGCD = min(
            self::gcd($this->smallBucket, $this->target),
            self::gcd($this->bigBucket, $this->target)
        );
        if ((self::gcd($this->smallBucket, $this->bigBucket) > $minTargetGCD)
        ) {
            return false;
        }
        return true;
    }

    /**
     * Validates that all values are non-negative
     *
     * @return boolean true if passes validation
     */
    public function valuesNonNegative()
    {
        if (($this->smallBucket < 0)
            || ($this->bigBucket < 0)
            || ($this->target < 0)
        ) {
            return false;
        }
        return true;
    }

    /**
     * Returns gcd of 2 integers
     *
     * @param integer $n
     * @param integer $m
     *
     * @return integer gcd
     */
    public static function gcd($n, $m)
    {
        if ($n==0 and $m==0) {
            return 1;
        }
        if ($n==$m and $n>=1) {
            return $n;
        }
        if ($m < $n) {
            return self::gcd($n-$m,$n);
        } else {
            return self::gcd($n,$m-$n);
        }
    }
}