<?php

use KzykHys\Steganography\Compressor\ZlibCompressor;
use KzykHys\Steganography\Image;
use KzykHys\Steganography\Processor;

class ProcessorTest extends \PHPUnit_Framework_TestCase
{

    public function testCompressor()
    {
        $processor = new Processor();
        $processor->setCompressor(new ZlibCompressor());
        $this->assertInstanceOf('KzykHys\\Steganography\\CompressorInterface', $processor->getCompressor());
    }

    public function testEncode()
    {
        $message = 'a48995845f83ee779c632fd1225224e0e07380fc61da8f495f3e25760fc0e0029034ca41960adb81aeceee4902a1163b';

        $processor = new Processor();
        $image = $processor->encode(__DIR__ . '/Resources/img/koala.jpg', $message);
        $image->write(__DIR__ . '/Resources/out/koala_out.png');

        return $message;
    }

    /**
     * @param string $expected
     * @depends testEncode
     */
    public function testDecode($expected)
    {
        $processor = new Processor();
        $message = $processor->decode(__DIR__ . '/Resources/out/koala_out.png');

        $this->assertEquals($expected, $message);
    }

    public function testEncoder()
    {
        $processor = new Processor();
        $processor->setEncoder(new \KzykHys\Steganography\Encoder\DefaultEncoder());

        $this->assertInstanceOf('KzykHys\\Steganography\\EncoderInterface', $processor->getEncoder());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidCompressor()
    {
        require_once __DIR__ . '/Resources/stub/InvalidCompressor.php';

        $processor = new Processor();
        $processor->setCompressor(new InvalidCompressor());
    }

} 