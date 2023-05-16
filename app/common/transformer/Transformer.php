<?php

namespace app\common\transformer;

/**
 * 转化器
 *
 * @author saviorlv <1042080686@qq.com>
 *
 * @since 2020年12月14日
 */
abstract class Transformer
{
    public function TransformerCollection($items): array
    {
        return array_map([$this, 'transformer'], $items);
    }

    abstract public function transformer($item);
}
