<?php

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('LICENSE')
    ->notName('README.md')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('phpunitu.xml*')
    ->notName('.gitignore')
    ->notName('.travis.yml')
    ->notName('build.xml')
    ->exclude('vendor')
    ->exclude('tests')
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->fixers(FixerInterface::ALL_LEVEL)
    ->finder($finder);
