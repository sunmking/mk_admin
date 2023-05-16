<?php

namespace app\common\transformer;

class PostTransformer extends Transformer
{
    public function transformer($item): array
    {
        return [
            'id' => $item['id'] ?: '',
            'title' => $item['title'] ?: '',
            'type' => $item['type'] ?: '',
            'month' => $item['month'] ?: '',
            'm_id' => $item['m_id'] ?: '',
            'm_name' => $item['m_name'] ?: '',
            'cargo_id' => $item['cargo_id'] ?: '',
            'cargo_name' => $item['cargo_name'] ?? '',
            'label_name' => $item['label_name'] ?? '',
            'origin' => $item['origin'] ?: '',
            'author' => $item['author'] ?: '',
            'res_id' => $item['res_id'] ?: '',
            'is_up' => $item['is_up'],
            'is_show' => $item['is_show'],
            'publish_time' => transformerDate($item['publish_time']) ?: '',
            'sort_id' => $item['sort_id'] ?: '',
            'content' => $item['content'] ?: '',
            'watch_num' => !empty($item['watch_num']) ? $item['watch_num'] : '0',
            'seo_title' => $item['seo_title'] ?: '',
            'seo_desc' => $item['seo_desc'] ?: '',
            'seo_keyword' => $item['seo_keyword'] ?: '',
            'summary' => $item['summary'] ?: '',
            'url' => $item['url'] ?: '',
            'tags' => !empty($item['tags']) ? $item['tags'] : null,
            'views' => $item['views'] ?: 0,
            'is_hot' => !empty($item['is_hot']),
            'is_index' => !empty($item['is_index']),
            'create_time' => transformerDate($item['create_time']) ?: '',
            'update_time' => transformerDate($item['update_time']) ?: '',
            'delete_time' => $item['delete_time'] ?: '',
            'status' => $item['status'] ?: '',

        ];
    }
}
