<?php

require_once('../../www/projects/VirtualFS/src/Autoload/src/Autoload/Autoload.php');

use Autoload\Autoload;

$al = new Autoload();
$al->registerNamespace('Versionable', 'src');
$al->register();
