<?php

require_once(__DIR__.'/../src/Autoload/src/Versionable/Autoload/Autoload.php');

use Versionable\Autoload\Autoload;

$al = new Autoload();
$al->registerNamespace('Versionable', __DIR__.'/../src');
$al->register();