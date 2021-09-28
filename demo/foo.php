<?php

use Shiren\Yao\Definition;

require __DIR__ . '/../vendor/autoload.php';

foreach (Definition::GongFirstGua as $gfg) {
    echo Definition::CS[$gfg][0] . PHP_EOL;
}