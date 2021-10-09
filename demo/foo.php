<?php

require __DIR__ . '/../vendor/autoload.php';

$map = [1, 2, 0, 0, 0, 3];
//$map = [1, 0, 0, 0, 0, 1];

$eye = \Shiren\Yao\Eye::create($map, [6, 10], [2, 2])->look();

$res = \Shiren\Yao\Visible::instance($eye)->show(true);
print_r($res);
