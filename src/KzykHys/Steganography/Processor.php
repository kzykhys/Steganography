<?php

namespace KzykHys\Steganography;

use KzykHys\Steganography\Compressor\ZlibCompressor;
use KzykHys\Steganography\Encoder\DefaultEncoder;
use KzykHys\Steganography\Image\Image;
use KzykHys\Steganography\Iterator\BinaryIterator;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Kazuyuki Hayashi
 */
class Processor
{

    const BITS_PER_PIXEL = 3;
    const LENGTH_BITS    = 48;

    /**
     * @var CompressorInterface
     */
    private $compressor;

    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->encoder    = new DefaultEncoder();
        $this->compressor = new ZlibCompressor();
    }

    /**
     * @param string $file
     * @param string $message
     * @param array  $options
     *
     * @throws \LogicException
     *
     * @return Image
     */
    public function encode($file, $message, array $options = [])
    {
        $image   = new Image($file);
        $message = $this->encodeMessage($message, $options);
        $pixels  = ceil(strlen($message) / self::BITS_PER_PIXEL + (self::LENGTH_BITS / self::BITS_PER_PIXEL));

        if ($pixels > $image->getPixels()) {
            throw new \LogicException('Number of pixels is fewer than ' . $pixels);
        }

        $image->setBinaryString(new BinaryIterator($message));

        return $image;
    }

    /**
     * @param string $file
     * @param array  $options
     *
     * @return mixed
     */
    public function decode($file, array $options = [])
    {
        $image  = new Image($file);
        $binary = $image->getBinaryString();

        return $this->decodeMessage($binary, $options);
    }

    /**
     * @param CompressorInterface $compressor
     *
     * @throws \RuntimeException
     *
     * @return $this
     */
    public function setCompressor(CompressorInterface $compressor)
    {
        if (!$compressor->isSupported()) {
            throw new \RuntimeException('Unsupported type of compressor: ' . $compressor->getName());
        }

        $this->compressor = $compressor;

        return $this;
    }

    /**
     * @return CompressorInterface
     */
    public function getCompressor()
    {
        return $this->compressor;
    }

    /**
     * @param EncoderInterface $encoder
     *
     * @return $this
     */
    public function setEncoder($encoder)
    {
        $this->encoder = $encoder;

        return $this;
    }

    /**
     * @return EncoderInterface
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * @param string $message
     * @param array  $options
     *
     * @return mixed
     */
    protected function encodeMessage($message, array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->encoder->setDefaultOptions($resolver);
        $options = $resolver->resolve($options);

        return $this->encoder->encode($message, $this->compressor, $options);
    }

    /**
     * @param string $binary
     * @param array  $options
     *
     * @return mixed
     */
    protected function decodeMessage($binary, array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->encoder->setDefaultOptions($resolver);
        $options = $resolver->resolve($options);

        return $this->encoder->decode($binary, $this->compressor, $options);
    }

} 