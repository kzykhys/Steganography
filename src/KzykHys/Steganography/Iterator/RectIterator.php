<?php

namespace KzykHys\Steganography\Iterator;

/**
 * @author Kazuyuki Hayashi
 */
class RectIterator implements \Iterator
{

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var int
     */
    private $x = 0;

    /**
     * @var int
     */
    private $y = 0;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct($width = 0, $height = 0)
    {
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * Return the current element
     *
     * @return mixed Can return any type.
     */
    public function current()
    {
        return [$this->x, $this->y];
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        if ($this->x + 1 < $this->width) {
            $this->x++;
        } else {
            $this->x = 0;
            $this->y++;
        }

        $this->index++;
    }

    /**
     * Return the key of the current element
     *
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     *
     * @return boolean The return value will be casted to boolean and then evaluated.
     *       Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->x < $this->width && $this->y < $this->height;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->index = 0;
        $this->x     = 0;
        $this->y     = 0;
    }

}