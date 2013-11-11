<?php

use KzykHys\Steganography\Iterator\BinaryIterator;

class BinaryIteratorTest extends PHPUnit_Framework_TestCase
{

    public function testIterator()
    {
        $iterator = new BinaryIterator('0011011011');
        $result   = iterator_to_array($iterator);
        $expected = [];
        $chunk = array_merge(array_chunk(str_split(sprintf('%048b', 10)), 3), [
            [0, 0, 1], [1, 0, 1], [1, 0, 1], [1, 0, 0]
        ]);

        foreach ($chunk as $values) {
            $expected[] = [
                'r' => $values[0],
                'g' => $values[1],
                'b' => $values[2],
            ];
        }

        $this->assertEquals($expected, $result);
    }

} 