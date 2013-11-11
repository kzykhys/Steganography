<?php
use KzykHys\Steganography\Compressor\MultipleCompressor;
use KzykHys\Steganography\Compressor\ZlibCompressor;

/**
 * @author Kazuyuki Hayashi
 */

class MultipleCompressorTest extends \PHPUnit_Framework_TestCase
{

    public function testName()
    {
        $compressor = new MultipleCompressor();
        $compressor->attach(new ZlibCompressor());
        $this->assertEquals('multiple', $compressor->getName());
    }

    public function testIsSupported()
    {
        $compressor = new MultipleCompressor();
        $compressor->attach(new ZlibCompressor());
        $this->assertTrue($compressor->isSupported());

        $compressor = new MultipleCompressor();
        $this->assertFalse($compressor->isSupported());
    }

    public function testEncodeAndDecode()
    {
        $compressor = new MultipleCompressor();
        $compressor->attach(new ZlibCompressor());
        $compressed = $compressor->compress('test');

        $this->assertEquals('test', $compressor->decompress($compressed));
    }

    /**
     * @expectedException LogicException
     */
    public function testEncodeBeforeAttach()
    {
        $compressor = new MultipleCompressor();
        $compressor->compress('test');
    }

    /**
     * @expectedException LogicException
     */
    public function testDecodeBeforeAttach()
    {
        $compressor = new MultipleCompressor();
        $compressor->decompress('test');
    }

    public function testPreferredChoice()
    {
        require_once __DIR__ . '/../Resources/stub/InvalidCompressor.php';

        $compressor = new MultipleCompressor(['preferred_choice' => 'zlib']);
        $compressor->attach(new ZlibCompressor());
        $compressor->attach(new InvalidCompressor());
        $compressor->compress('test');
    }

    public function testInvalidPreferredChoice()
    {
        require_once __DIR__ . '/../Resources/stub/InvalidCompressor.php';

        $compressor = new MultipleCompressor(['preferred_choice' => 'invalid']);
        $compressor->attach(new ZlibCompressor());
        $compressor->attach(new InvalidCompressor());
        $compressor->compress('test');
    }

} 