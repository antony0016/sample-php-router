<?php

require __DIR__ . '/vendor/autoload.php';

use SekiXu\SampleRouter\Application\Library\Config;
use SekiXu\SampleRouter\Application\Library\App;

App::run();

echo Config::get('LOG_PATH');
