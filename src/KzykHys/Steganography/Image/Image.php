<?php

namespace KzykHys\Steganography\Image;

use KzykHys\Steganography\Iterator\BinaryIterator;
use KzykHys\Steganography\Iterator\RectIterator;
use KzykHys\Steganography\Processor;

/**
 * @author Kazuyuki Hayashi
 */
class Image
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var resource
     */
    private $image;

    /**
     * @var int
     */
    private $width = 0;

    /**
     * @var int
     */
    private $height = 0;

    /**
     * @var int
     */
    private $pixels = 0;

    /**
     * @param string $path
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('File Not Found: ' . $path);
        }

        $this->path = $path;

        $this->initialize();
    }

    /**
     * @param BinaryIterator $binary
     *
     * @return $this
     */
    public function setBinaryString(BinaryIterator $binary)
    {
        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_ASSOC);
        $iterator->attachIterator(new RectIterator($this->width, $this->height), 'rect');
        $iterator->attachIterator($binary, 'bin');

        foreach ($iterator as $current) {
            $this->setPixel($current['rect'][0], $current['rect'][1], $current['bin']);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getBinaryString()
    {
        $iterator = new RectIterator($this->width, $this->height);
        $length   = '';
        $data     = '';
        $offset   = Processor::LENGTH_BITS / Processor::BITS_PER_PIXEL;

        foreach (new \LimitIterator($iterator, 0, $offset) as $value) {
            $length .= $this->getPixel($value[0], $value[1]);
        }

        $bits   = (int) bindec($length);
        $length = (int) ceil($bits / Processor::BITS_PER_PIXEL);

        foreach (new \LimitIterator($iterator, $offset, $length) as $value) {
            $data .= $this->getPixel($value[0], $value[1]);
        }

        $data = substr($data, 0, $bits);

        return $data;
    }

    /**
     * @param $x
     * @param $y
     * @param $values
     *
     * @return $this
     */
    public function setPixel($x, $y, $values) {
        $rgb = $this->getRGB($x, $y);

        foreach ($rgb as $name => $value) {
            $rgb[$name] = bindec(substr(decbin($value), 0, -1) . $values[$name]);
        }

        $color = imagecolorallocate($this->image, $rgb['r'], $rgb['g'], $rgb['b']);
        imagesetpixel($this->image, $x, $y, $color);
        imagecolordeallocate($this->image, $color);

        return $this;
    }

    /**
     * @param $x
     * @param $y
     *
     * @return string
     */
    public function getPixel($x, $y)
    {
        $result = '';
        $rgb = $this->getRGB($x, $y);

        foreach ($rgb as $value) {
            $result .= substr(decbin($value), -1, 1);
        }

        return $result;
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function write($path)
    {
        return imagepng($this->image, $path, 0);
    }

    /**
     * @return bool
     */
    public function render()
    {
        return imagepng($this->image, null, 0);
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getPixels()
    {
        return $this->pixels;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     *
     */
    public function __destruct()
    {
        if ($this->image) {
            imagedestroy($this->image);
        }
    }

    /**
     * @throws \RuntimeException
     *
     * @return resource
     */
    protected function initialize()
    {
        $info         = getimagesize($this->path);
        $this->width  = $info[0];
        $this->height = $info[1];
        $this->pixels = $this->width * $this->height;
        $type         = $info[2];

        switch ($type) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($this->path);
                break;
            case IMAGETYPE_GIF;
                $this->image = imagecreatefromgif($this->path);
                break;
            case IMAGETYPE_PNG;
                $this->image = imagecreatefrompng($this->path);
                break;
            default:
                throw new \RuntimeException('Unsupport image type ' . $type);
        }

        imagealphablending($this->image, false);
    }

    /**
     * @param $x
     * @param $y
     *
     * @return array
     */
    protected function getRGB($x, $y) {
        $rgb = imagecolorat($this->image, $x, $y);

        return [
            'r' => ($rgb >> 16) & 0xFF,
            'g' => ($rgb >> 8) & 0xFF,
            'b' => $rgb & 0xFF
        ];
    }

} 