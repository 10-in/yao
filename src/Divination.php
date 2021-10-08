<?php

namespace Shiren\Yao;

/**
 * 占卜算法(主要为六爻)
 */
class Divination
{
    /**
     * 宫转为五行
     * @param int $i 宫的索引转为
     * @return int
     */
    public static function g2e(int $i): int
    {
        return Definition::Gong2Element[$i];
    }
    /**
     * 旬空算法(根据日干，日支，计算出对应的两个空亡地支)
     * @param int $dayGan 日干
     * @param int $dayZhi 日支
     * @return int[] 两个旬空地支
     */
    public static function kong(int $dayGan, int $dayZhi): array
    {
        $s = 9 - $dayGan + $dayZhi;
        return [($s + 1) % 12, ($s + 2) % 12];
    }

    /**
     * 根据象的索引获取对应的世爻、应爻所在爻位
     * @param int $xiang
     * @return int[]
     */
    public static function sy(int $xiang): array
    {
        $y = Definition::Xiang4Yao[$xiang];
        $s = ($y + 3) % 6;
        return [$y, $s];
    }

    /**
     * 根据八宫和八象确定64卦的索引
     * @param int $gi 八宫索引
     * @param int $xi 八象索引
     * @return int
     */
    public static function gua64(int $gi, int $xi): int
    {
        $g = $gi * 9;
        foreach ([1,2,4,8,16,8] as $p) {
            if ($xi-- < 1) return $g;
            $g = ($g & (~$p)) | ($g ^ $p);
        }
        return $xi == 0 ? $g : ($g & 0b111000) + $gi;
    }

    /**
     * 卦对应的宫
     * @param int $i
     * @return int
     */
    public static function guaGong(int $i): int
    {
        return Definition::GuaGong[$i];
    }

    /**
     * 卦对应的象
     * @param int $i
     * @return int
     */
    public static function guaXiang(int $i): int
    {
        return Definition::GuaXiang[$i];
    }
}