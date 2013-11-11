<?php
use KzykHys\Steganography\Image\Image;

/**
 * @author Kazuyuki Hayashi
 */

class ImageTest extends \PHPUnit_Framework_TestCase
{

    public function testSize()
    {
        $image = new Image(__DIR__ . '/../Resources/img/3.jpg');
        $this->assertEquals(3, $image->getWidth());
        $this->assertEquals(3, $image->getHeight());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPath()
    {
        $image = new Image(__DIR__.'/foo.jpg');
    }

} 