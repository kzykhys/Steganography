<?php

use KzykHys\Steganography\Compressor\Compressor;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvalidCompressor extends Compressor
{

    /**
     * Compress a string
     *
     * @param string $data
     *
     * @return mixed
     */
    public function compress($data)
    {
        return $data;
    }

    /**
     * Uncompress a compressed string
     *
     * @param mixed $data
     *
     * @return string
     */
    public function decompress($data)
    {
        return $data;
    }

    /**
     * @param OptionsResolverInterface $resolver
     *
     * @return \KzykHys\Steganography\CompressorInterface
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function isSupported()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invalid';
    }

}