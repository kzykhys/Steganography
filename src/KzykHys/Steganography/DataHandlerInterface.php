<?php

namespace KzykHys\Steganography;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Kazuyuki Hayashi
 */
interface DataHandlerInterface
{

    /**
     * @param string              $data
     * @param CompressorInterface $compressor
     * @param array               $options
     *
     * @return mixed
     */
    public function encode($data, CompressorInterface $compressor, array $options = []);

    /**
     * @param string              $data
     * @param CompressorInterface $compressor
     * @param array               $options
     *
     * @return mixed
     */
    public function decode($data, CompressorInterface $compressor, array $options = []);

    /**
     * @param OptionsResolverInterface $resolver
     *
     * @return DataHandlerInterface
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

} 