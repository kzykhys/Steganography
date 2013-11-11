<?php

namespace KzykHys\Steganography\Iterator;

use KzykHys\Steganography\Processor;

/**
 * @author Kazuyuki Hayashi
 */
class BinaryIterator implements \Iterator
{

    /**
     * @var string
     */
    private $string;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var int
     */
    private $length = 0;

    /**
     * @var int
     */
    private $count = Processor::BITS_PER_PIXEL;

    /**
     * @param     $string
     * @param int $count
     */
    public function __construct($string, $count = Processor::BITS_PER_PIXEL)
    {
        $this->count  = $count;
        $this->string = sprintf('%048b', strlen($string)) . $string;
        $this->length = strlen($this->string);
    }

    /**
     * Return the current element
     *
     * @return mixed Can return any type.
     */
    public function current()
    {
        $part  = substr($this->string, ($this->index * $this->count), $this->count);
        $chars = array_pad(str_split($part), $this->count, 0);

        return [
            'r' => $chars[0],
            'g' => $chars[1],
            'b' => $chars[2],
        ];
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
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
        return $this->index * $this->count < $this->length;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->index = 0;
    }

}