Steganography
=============

Simple implementation of Steganography (Hiding a hidden message within an image)

Installation
------------

``` json

```

Usage
-----

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

``` php
<?php

require __DIR__ . '/vendor/autoload.php';

$processor = new KzykHys\Steganography\Processor();
$message = $processor->decode('/path/to/image.png');

echo $message; // "Message to hide"
```

