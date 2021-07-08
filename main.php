<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Console\FindConmmand;
$app = new Application('lyrae-php', '1.0.0');
$findCommand = new FindConmmand();
$app -> add($findCommand);
$app -> run();
$ps = new Parser;
?>
