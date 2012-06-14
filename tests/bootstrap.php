<?php

function includeIfExists($file)
{
    if (file_exists($file)) {
        return include $file;
    }
}

if ((!$loader = includeIfExists(__DIR__.'/../vendor/autoload.php')) && (!$loader = includeIfExists(__DIR__.'/../../../autoload.php'))) {
    die('You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install --dev'.PHP_EOL);
}

$loader->add('Versionable\Tests\Prospect', __DIR__);
$loader->add('Versionable\Prospect', __DIR__.'/../src');
$loader->add('Versionable\Common', __DIR__.'/../vendor/versionable-common/src');
