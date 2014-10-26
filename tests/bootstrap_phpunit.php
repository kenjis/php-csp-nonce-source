<?php

ini_set('display_errors', 1);
error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/src/TestCase.php';

class_alias('Kenjis\Csp\Csp', 'Csp');

// AspectMock
$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug'        => true,
    'includePaths' => [__DIR__.'/../src'],
    'cacheDir'     => __DIR__.'/cache/AspectMock',
]);
