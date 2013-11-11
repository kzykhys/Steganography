<?php

namespace KzykHys\Steganography;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Kazuyuki Hayashi
 */
interface CompressorInterface
{

    /**
     * Compress a string
     *
     * @param string $data
     *
     * @return mixed
     */
    public function compress($data);

    /**
     * Uncompress a compressed string
     *
     * @param mixed $data
     *
     * @return string
     */
    public function decompress($data);

    /**
     * @param OptionsResolverInterface $resolver
     *
     * @return CompressorInterface
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

    /**
     * @return bool
     */
    public function isSupported();

    /**
     * @return string
     */
    public function getName();

} 