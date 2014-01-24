<?php

namespace KzykHys\Steganography\Encoder;

use KzykHys\Steganography\CompressorInterface;
use KzykHys\Steganography\EncoderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Kazuyuki Hayashi
 */
class DefaultEncoder implements EncoderInterface
{

    /**
     * {@inheritdoc}
     */
    public function encode($data, CompressorInterface $compressor, array $options = [])
    {
        $compressed = base64_encode($compressor->compress($data));
        $bin        = '';
        $length     = strlen($compressed);

        for ($i = 0; $i < $length; $i++) {
            $bin .= sprintf('%08b', ord($compressed[$i]));
        }

        return $bin;
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, CompressorInterface $compressor, array $options = [])
    {
        $chars  = str_split($data, 8);
        $compressed = '';

        foreach ($chars as $char) {
            $compressed .= chr(bindec($char));
        }

        return $compressor->decompress(base64_decode($compressed));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return $this;
    }

}