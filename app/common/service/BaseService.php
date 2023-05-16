<?php

namespace app\common\service;

use app\common\traits\ApiResponseTraits;
use Carbon\Carbon;
use think\helper\Str;

class BaseService
{
    use ApiResponseTraits;

    /**
     * 所有列表的筛选条件构造
     */
    /**
     * 所有列表的筛选条件构造
     */
    public function getFilterConditions($filter): array
    {
        $filter = array_filter_empty_value($filter);
        $conditions = [];

        $filter && $conditions = $this->formatConditions($filter);

        return $this->returnMsg(200, null, $conditions);
    }

    /**
     * 构造查询条件
     */
    public function formatConditions($filter): array
    {
        if (empty($filter)) {
            return [];
        }

        $conditions = [];
        foreach ($filter as $k => $v) {
            if (mb_substr($k, -9) == 'time_from') {
                $conditions[] = [mb_substr($k, 0, -5), '>=', Carbon::parse($v)->getTimestamp()];
            } elseif (mb_substr($k, -7) == 'time_to') {
                $v = date('Y-m-d', Carbon::parse($v)->getTimestamp());
                $v .= ' 23:59:59';
                $conditions[] = [mb_substr($k, 0, -3), '<=', Carbon::parse($v)->getTimestamp()];
            } elseif (Str::contains($k, 'name') !== false) {
                $conditions[] = [$k, 'LIKE', "%{$v}%"];
            } elseif (Str::contains($k, 'title') !== false) {
                $conditions[] = [$k, 'LIKE', "%{$v}%"];
            } elseif (Str::contains($k, '_no') !== false) {
                $conditions[] = [$k, 'LIKE', "%{$v}%"];
            } elseif (Str::contains($k, 'specification') !== false) {
                $conditions[] = [$k, 'LIKE', "%{$v}%"];
            } elseif (str_contains($k, 'code')) { //客户礼券编码
                $conditions[] = [$k, 'LIKE', "%{$v}%"];
            } elseif (str_contains($k, 'phone')) { // phone
                $conditions[] = [$k, 'LIKE', "%{$v}%"];
            } else {
                $conditions[] = [$k, '=', $v];
            }
        }

        return $conditions;
    }
}
