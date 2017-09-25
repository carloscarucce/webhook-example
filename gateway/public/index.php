<?php
ini_set('display_errors', 0);

require __DIR__.'/../vendor/autoload.php';
(new \Corviz\Application(__DIR__.'/..'))->run();
