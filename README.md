Steganography
=============

[![Latest Unstable Version](https://poser.pugx.org/kzykhys/steganography/v/unstable.png)](https://packagist.org/packages/kzykhys/steganography)
[![Build Status](https://travis-ci.org/kzykhys/Steganography.png?branch=master)](https://travis-ci.org/kzykhys/Steganography)
[![Coverage Status](https://coveralls.io/repos/kzykhys/Steganography/badge.png)](https://coveralls.io/r/kzykhys/Steganography)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/28e8157b-8b33-4d52-8eda-986a1bffca1d/mini.png)](https://insight.sensiolabs.com/projects/28e8157b-8b33-4d52-8eda-986a1bffca1d)

Simple PHP implementation of Steganography (Hiding a hidden message within an image)

Requirements
------------

* PHP5.4+

Installation
------------

Update your composer.json and run `composer update`

``` json
{
    "require": {
        "kzykhys/steganography": "dev-master"
    }
}
```

Usage
-----

### Put your message into an image

``` php
<?php

require __DIR__ . '/vendor/autoload.php';

$processor = new KzykHys\Steganography\Processor();
$image = $processor->encode('/path/to/image.jpg', 'Message to hide'); // jpg|png|gif

// Save image to file
$image->write('/path/to/image.png'); // png only

// Or outout image to stdout
$image->render();
```

### Extract message from an image

``` php
<?php

require __DIR__ . '/vendor/autoload.php';

$processor = new KzykHys\Steganography\Processor();
$message = $processor->decode('/path/to/image.png');

echo $message; // "Message to hide"
```

License
-------

The MIT License

Author
------

Kazuyuki Hayashi (@kzykhys)