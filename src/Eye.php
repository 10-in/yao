<?php

namespace Shiren\Yao;

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
     * @var array 六爻占卜时对应的干支纪年法时间，依次为年干、月干、日干
     */
    public $g = [];
    /**
     * @var array 六爻占卜时对应的干支纪年法时间，依次为年支、月支、日支
     */
    public $z = [];

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
    public function __construct(array $times)
    {
        $this->times = $times;
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
        // 算五行

    }

    public function toArray(): array
    {
        return [
            'name' => $this->name()
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
}