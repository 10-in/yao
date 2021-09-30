<?php

use Shiren\Yao\Definition;

require __DIR__ . '/../vendor/autoload.php';

$map = [1, 2, 0, 0, 0, 3];

$yao = [];
for ($i =0; $i<6; $i++) {
    $yao[] = new Shiren\Yao\Yao($i, $map[$i]);
}

$eye = new \Shiren\Yao\Eye($yao);

$eye->look();

print_r($eye->toArray());