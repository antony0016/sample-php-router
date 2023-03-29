<?php

require __DIR__ . '/vender/autoload.php';

use SekiXu\SampleRouter\Application\Library\Config;

echo Config::get('LOG_PATH');
