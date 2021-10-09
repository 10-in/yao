<?php

namespace Shiren\Yao;

use Shiren\TAM\Algorithm;

/**
 * 看六爻的基础数据识别六爻
 */
class Eye
{
    /**
     * @var array []Yao 六爻六次的结果
     */
    public $times = [];

    /**
     * @var array 六爻占卜时对应的干支纪年法时间日柱
     */
    public $dayColumn = [];

    /**
     * @var array 六爻占卜时对应的干支纪年法时间月柱
     */
    public $monthColumn = [];

    /**
     * @var int 前卦
     */
    public $front;

    /**
     * @var int|null 后卦
     */
    public $back;

    /**
     * @var int 卦的五行
     */
    public $element;

    /**
     * @param array []Yao $times
     */
    public function __construct(array $times, array $monthColumn, array $dayColumn)
    {
        /** @var Yao $yao */
        foreach ($times as $yao) {
            $this->times[$yao->no] = $yao;
        }
        $this->monthColumn = $monthColumn;
        $this->dayColumn = $dayColumn;
    }

    /**
     * 看六次爻卦的结果得出盘面基本信息
     */
    public function look(): Eye
    {
        $this->recognize();
        $this->load();
        return $this;
    }

    /**
     * 识卦
     */
    public function recognize()
    {
        $f = $b = 0b000000;
        $dynamic = false;
        /** @var Yao $y */
        foreach ($this->times as $y) {
            if ($y->data > 1) {
                $dynamic = true;
            }
            switch ($y->data) {
                case 1:
                    $f = $f | 1<<$y->no;
                    $b = $b | 1<<$y->no;
                    break;
                case 2:
                    $b = $b | 1<<$y->no;
                    break;
                case 3:
                    $f = $f | 1<<$y->no;
                }
        }
        $dynamic || $b = null;
        $this->front = $f;
        $this->back = $b;
    }

    /**
     * 装卦
     */
    public function load()
    {
        $gong = Divination::guaGong($this->front);
        $this->element = Divination::g2e($gong); // 装五行
        $this->loadZhi(); // 装地支
        $this->loadSY(); // 装世爻应爻
        $this->loadRelation(); // 装卦的六亲
        $this->loadAnimals(); // 装六兽
        $this->loadEmpty(); // 装旬空
        $this->loadJPD();
        $this->loadDefect($gong);
    }

    public function toArray(): array
    {
        return [
            'name'      => $this->name(),
            'element'   => $this->element,
        ];
    }

    /**
     * 计算出卦的名称，包含前卦和后卦
     * @return array
     */
    protected function name(): array
    {
        $names = [Definition::GuaName[$this->front]];
        is_null($this->back) || $names[] = Definition::GuaName[$this->back];
        return $names;
    }

    /**
     * 装卦的地支
     */
    protected function loadZhi()
    {
        // 装前卦
        $out    = $this->front >> 3;
        $inside = $this->front & 0b000111;

        $i = Definition::GuaZ[$inside][0];
        $o = Definition::GuaZ[$out][1];

        $gz = array_merge($i, $o);

        /** @var Yao $yao */
        foreach ($this->times as $yao) {
            $yao->z = $gz[$yao->no];
        }

        if ($this->back != null) {
            // 装后卦
            $out    = $this->back >> 3;
            $inside = $this->back & 0b000111;

            $i = Definition::GuaZ[$inside][0];
            $o = Definition::GuaZ[$out][1];

            $gz = array_merge($i, $o);

            /** @var Yao $yao */
            foreach ($this->times as $yao) {
                if ($yao->change != null) {
                    $yao->change->z = $gz[$yao->no];
                }
            }
        }
    }

    /**
     * 装卦的世爻应爻
     */
    protected function loadSY()
    {
        $x = Divination::guaXiang($this->front);
        $position = Divination::sy($x);
        $this->times[$position[0]]->sy = 2;
        $this->times[$position[1]]->sy = 1;
    }

    /**
     * 装卦的六亲
     */
    protected function loadRelation()
    {
        /** @var Yao $yao */
        foreach ($this->times as $yao) {
            $yao->relation = Algorithm::spirit($this->element, Algorithm::z2e($yao->z));
            if ($yao->change != null) {
                $yao->change->relation = Algorithm::spirit($this->element, Algorithm::z2e($yao->change->z));
            }
        }
    }

    /**
     * 装卦的六兽
     */
    protected function loadAnimals()
    {
        $start = Definition::AnimalStart[$this->dayColumn[0]];

        /** @var Yao $yao */
        foreach ($this->times as $yao) {
            $yao->animal = $start % 6;
            $start++;
        }
    }

    /**
     * 装旬空
     */
    protected function loadEmpty()
    {
        $kong = Divination::kong($this->dayColumn[0], $this->dayColumn[1]);

        /** @var Yao $yao */
        foreach ($this->times as $yao) {
            if (in_array($yao->z, $kong)) {
                $yao->empty = 1;
            }
            if ($yao->change != null) {
                if (in_array($yao->change->z, $kong)) {
                    $yao->change->empty = 1;
                }
            }
        }
    }

    /**
     * 装建/破/动
     */
    protected function loadJPD()
    {
        /** @var Yao $yao */
        foreach ($this->times as $yao) {
            if ($yao->z == $this->monthColumn[1]) {
                $yao->m = 1;
            } else if (abs($yao->z - $this->monthColumn[1]) == 6) {
                $yao->m = 2;
            }

            if (abs($yao->z - $this->dayColumn[1]) == 6) {
                $yao->d = 1;
            }

            if ($yao->change != null) {
                if ($yao->change->z == $this->monthColumn[1]) {
                    $yao->change->m = 1;
                } else if (abs($yao->change->z - $this->monthColumn[1]) == 6) {
                    $yao->change->m = 2;
                }
                if (abs($yao->change->z - $this->dayColumn[1]) == 6) {
                    $yao->change->d = 1;
                }
            }
        }
    }

    /**
     * 修复缺失的六亲(在内外卦都没有，则为缺失六亲)
     * @param int $gong
     */
    protected function loadDefect(int $gong)
    {
        $exists = 0b00000; // 用二进制表示是否存在对应的六亲，依次为父、兄、子、才、官，默认为不存在
        /** @var Yao $yao */
        foreach ($this->times as $yao) {
            $exists = $exists | 1<<$yao->relation;
            if($yao->change != null) {
                $exists = $exists | 1<<$yao->change->relation;
            }
        }
        if ($exists != 0b11111) {
            $GuaZhi = array_merge(...Definition::GuaZ[$gong]); // 根据当前卦所在的宫的第一个卦，得到对应的地支
            $relations = array_map(function ($z) {
                return [$z, Algorithm::spirit($this->element, Algorithm::z2e($z))]; // [地支，六亲]
            }, $GuaZhi);

            // TODO 可能产生同一个六亲被伏两次的情况
            foreach ($relations as $index => $r) {
                if ((($exists >> $r[1]) & 0b00001) == 0) { // 判断当前位置$index的六亲是否已经存在
                    /** @var Yao $yao */
                    $yao = $this->times[$index];
                    $yao->peace = $r;
                }
            }
        }
    }
}