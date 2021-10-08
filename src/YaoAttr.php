<?php

namespace Shiren\Yao;

class YaoAttr
{
    /**
     * @var int 地支
     */
    public $z;

    /**
     * @var int 六亲
     */
    public $relation;

    /**
     * @var int 旬空(0无，1有)
     */
    public $empty = 0;

    /**
     * @var int 1-月建/2-月破
     */
    public $m = 0;

    /**
     * @var int 0无 1-暗动
     */
    public $d;
}