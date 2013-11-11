<?php

namespace KzykHys\Steganography\Compressor;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Kazuyuki Hayashi
 */
class ZlibCompressor extends Compressor
{

    /**
     * {@inheritdoc}
     */
    public function compress($data)
    {
        return gzcompress($data, $this->options['level']);
    }

    /**
     * {@inheritdoc}
     */
    public function decompress($data)
    {
        return gzuncompress($data);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        return function_exists('gzcompress');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'level' => -1
        ]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zlib';
    }

}