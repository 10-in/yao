<?php

use Shiren\TAM\Factory;
use Shiren\Yao\Eye;
use Shiren\Yao\Visible;

require __DIR__ . '/../vendor/autoload.php';

$map = [3, 0, 0, 0, 0, 0];

$monthColumn    = [0, 0];
$dayColumn      = [0, 0];

$eye = Eye::create($map, $monthColumn, $dayColumn)->look();

$res = Visible::instance($eye)->show(true);
