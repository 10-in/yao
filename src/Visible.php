<?php
namespace Shiren\Yao;

use Shiren\TAM\Str;

/**
 * 结果可视化
 */
class Visible
{
    /** @var Eye */
    public $eye;

    public static function instance(Eye $eye): self
    {
        return new static($eye);
    }

    public function __construct(Eye $eye)
    {
        $this->eye = $eye;
    }

    public function show(bool $isCli=false): array
    {
        return $isCli ? $this->showInCli(): $this->stringify();
    }

    protected function showInCli(): array
    {
        $times = array_reverse($this->eye->times);

        $GP = ['- -', '---', '-x-', '-0-'];

        echo Str::g($this->eye->monthCol[0]) . Str::z($this->eye->monthCol[1]) . '月'
            . Str::g($this->eye->dayCol[0]) . Str::z($this->eye->dayCol[1]) . '日' . PHP_EOL;
        echo implode('之', $this->eye->name()) . ' ' . Str::e($this->eye->element) . PHP_EOL;

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
            $fu = $yao->peace ? '伏' . Str::z($yao->peace[0]) . Definition::Relations[$yao->peace[1]] : '　　　';


            $No = $yao->no + 1;
            echo "{$No} {$sy} {$animal} {$r} {$GP[$yao->type]} {$zhi}[$empty $jp $fu] {$cz} {$cr} \n";
        }
        return [];
    }

    protected function stringify(): array
    {
        $data = $this->eye->toArray();

        $data['element'] = Str::e($data['element']);

        foreach ($data['times'] as &$item) {
            $item['sy']         = ['', '应', '世'][$item['sy']];
            $item['animal']     = Definition::Animals[$item['animal']];
            $item['peace']      = is_null($item['peace']) ? '' : Str::z($item['peace'][0]) . Definition::Relations[$item['peace'][1]];
            $item['z']          = Str::z($item['z']);
            $item['relation']   = Definition::Relations[$item['relation']];
            $item['empty']      = $item['empty'] == 0 ? '' : '空';
            $item['m']          = ['', '建', '破'][$item['m']];
            $item['d']          = $item['d'] == 0 ? '' : '动';
            if (!is_null($item['change'])) {
                $item['change']['z']          = Str::z($item['change']['z']);
                $item['change']['relation']   = Definition::Relations[$item['change']['relation']];
                $item['change']['empty']      = $item['change']['empty'] == 0 ? '' : '空';
                $item['change']['m']          = ['', '建', '破'][$item['change']['m']];
                $item['change']['d']          = $item['change']['d'] == 0 ? '' : '动';
            }
        }

        return $data;
    }
}