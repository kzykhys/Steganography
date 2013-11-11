<?php

namespace KzykHys\Steganography\Compressor;

use KzykHys\Steganography\CompressorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Kazuyuki Hayashi
 */
class MultipleCompressor extends Compressor
{

    /**
     * @var CompressorInterface[]
     */
    private $children = [];

    /**
     * @var CompressorInterface
     */
    private $selectedCompressor;

    /**
     * @param CompressorInterface $compressor
     *
     * @return $this
     */
    public function attach(CompressorInterface $compressor)
    {
        $this->children[$compressor->getName()] = $compressor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function compress($data)
    {
        if (!$this->selectCompressor()) {
            throw new \LogicException('Attach at least 1 compressor');
        }

        return $this->selectedCompressor->compress($data);
    }

    /**
     * {@inheritdoc}
     */
    public function decompress($data)
    {
        if (!$this->selectCompressor()) {
            throw new \LogicException('Attach at least 1 compressor');
        }

        return $this->selectedCompressor->decompress($data);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'preferred_choice' => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        return $this->selectCompressor();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'multiple';
    }

    /**
     * @return bool
     */
    protected function selectCompressor()
    {
        if ($this->selectedCompressor) {
            return true;
        }

        if (isset($this->children[$this->options['preferred_choice']])) {
            $this->selectedCompressor = $this->children[$this->options['preferred_choice']];

            if ($this->selectedCompressor->isSupported()) {
                return true;
            }
        }

        foreach ($this->children as $compressor) {
            if ($compressor->isSupported()) {
                $this->selectedCompressor = $compressor;

                return true;
            }
        }

        return false;
    }

}