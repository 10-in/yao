<?php

namespace Shiren\Yao;

/**
 * 爻的信息
 */
class Yao extends YaoAttr
{
    /**
     * @var int 六爻编号n，0～5
     */
    public $no;

    /**
     * @var int 六爻数据 0阴爻 1阳爻 2动阴爻 3动阳爻
     */
    public $data;

    /**
     * @var int 世/应爻内容 0无 1应 2世
     */
    public $sy = 0;

    /**
     * @var string 六首
     */
    public $animal;

    /**
     * @var string 伏神
     */
    public $peace;

    /**
     * @var YaoAttr|null 变卦信息
     */
    public $change;

    public function __construct(int $no, int $data)
    {
        $this->no = $no;
        $this->data = $data;
    }
}