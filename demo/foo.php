<?php

use Shiren\TAM\Str;
use Shiren\Yao\Definition;
use Shiren\Yao\Yao;

require __DIR__ . '/../vendor/autoload.php';

$map = [1, 2, 0, 0, 0, 3];

$yao = [];
for ($i =0; $i<6; $i++) {
    $yao[] = new Shiren\Yao\Yao($i, $map[$i]);
}

$eye = new \Shiren\Yao\Eye($yao, [6, 10], [2, 2]);

$eye->look();

print_r($eye->toArray());

$times = array_reverse($eye->times);

/** @var Yao $yao */
foreach ($times as $yao) {
    $sy = ['　', '应', '世'][$yao->sy];
    $zhi = Str::z($yao->z);

    $r = Definition::Relations[$yao->relation];

    if ($yao->change) {
        $cz = Str::z($yao->change->z);
        $cr = Definition::Relations[$yao->change->relation];
    } else {
        $cz = '　';
        $cr = '　';
    }
    $animal = Definition::Animals[$yao->animal];

    $empty = ['　', '空'][$yao->empty];
    $jp = ['　', '建', '破'][$yao->m];


    echo "{$yao->no} {$sy} {$animal} {$r} {$yao->data} {$zhi}[$empty $jp] {$cz} {$cr} \n";
}