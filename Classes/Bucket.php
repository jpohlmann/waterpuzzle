<?php
class Bucket{
    /**
     * Capacity of bucket
     *
     * @var integer
     */
    protected $capacity;

    /**
     * Current value of bucket
     *
     * @var integer
     */
    protected $current;

    /**
     * Order of buckets in the bucket list
     *
     * @var integer
     */
    protected $order;

    /**
     * Construct, set the capacity and the order
     *
     * @param integer $capacity
     * @param integer $order
     */
    public function __construct($capacity, $order)
    {
        $this->setCapacity($capacity);
        $this->setOrder($order);
        $this->setCurrent(0);
    }

    /**
     * Get the capacity
     *
     * @return integer Capacity
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set the capacity
     *
     * @param integer $capacity
     *
     * @return Bucket
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
        return $this;
    }

    /**
     * Get the current
     *
     * @return integer Current
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Set the current
     *
     * @param integer $current Current value
     *
     * @return Bucket
     */
    public function setCurrent($current)
    {
        $this->current = $current;
        return $this;
    }

    /**
     * Get the order
     *
     * @return integer Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the order
     *
     * @param integer $order Order
     *
     * @return Bucket
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Gets the space left in the bucket
     *
     * @return integer Space left
     */
    public function getSpaceLeft()
    {
        return $this->capacity - $this->current;
    }

    /**
     * Check if the bucket is full
     *
     * @return boolean true if bucket full
     */
    public function isFull()
    {
        if ($this->capacity == $this->current) {
            return true;
        }
        return false;
    }

    /**
     * Check if the bucket is empty
     *
     * @return boolean true if bucket empty
     */
    public function isEmpty()
    {
        if ($this->current == 0) {
            return true;
        }
        return false;
    }
}