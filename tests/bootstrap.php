<?php

require_once(__DIR__.'/../vendor/autoload/src/Versionable/Autoload/Autoload.php');

use Versionable\Autoload\Autoload;

$al = new Autoload();
$al->registerNamespace('Versionable\Tests\Prospect', __DIR__.'/../tests');
$al->registerNamespace('Versionable\Prospect', __DIR__.'/../src');
$al->registerNamespace('Versionable\Common', __DIR__.'/../vendor/versionable/src');
$al->register();
