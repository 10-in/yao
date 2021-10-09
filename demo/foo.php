<?php

use Shiren\TAM\Factory;
use Shiren\Yao\Eye;
use Shiren\Yao\Visible;

require __DIR__ . '/../vendor/autoload.php';

$map = [1, 2, 0, 0, 0, 3];
//$map = [1, 0, 0, 0, 0, 1];

$monthColumn = [
    Factory::g('geng'), // 6 庚
    Factory::z('wu'), // 10 戌
];
$dayColumn = [
    Factory::g('bing'), // 2 丙
    Factory::z('yin'), // 2 寅
];

$eye = Eye::create($map, $monthColumn, $dayColumn)->look();

$res = Visible::instance($eye)->show(true);
echo json_encode($res, JSON_UNESCAPED_UNICODE);
