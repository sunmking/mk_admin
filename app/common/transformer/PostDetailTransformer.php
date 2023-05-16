<?php

namespace app\common\transformer;

class PostDetailTransformer extends Transformer
{
    public function transformer($item): array
    {
        return [
            'id' => $item['id'] ?: '',
            'title' => $item['title'] ?: '',
            'month' => $item['month'] ?: '',
            'seo_title' => $item['seo_title'] ?: '',
            'seo_desc' => $item['seo_desc'] ?: '',
            'seo_keyword' => $item['seo_keyword'] ?: '',
            'sort_id' => $item['sort_id'] ?: '',
            'res_id' => $item['res_id'] ?: '',
            'summary' => $item['summary'] ?: '',
            'url' => $item['url'] ?: '',
            'origin' => $item['origin'] ?: '',
            'author' => $item['author'] ?: '',
            'tags' => !empty($item['tags']) ? explode(',', $item['tags']) : null,
            'm_id' => $item['m_id'] ?: '',
            'm_name' => $item['m_name'] ?? '',
            'cargo_id' => $item['cargo_id'] ?: '',
            'cargo_name' => $item['cargo_name'] ?? '',
            'label_name' => $item['label_name'] ?? '',

            'views' => $item['views'] ?? 0,
            'is_hot' => !empty($item['is_hot']),
            'is_index' => !empty($item['is_index']),
            'is_up' => $item['is_up'],
            'is_show' => $item['is_show'],
            'create_time' => transformerDate($item['create_time']) ?: '',
            'update_time' => transformerDate($item['update_time']) ?: '',
            'delete_time' => $item['delete_time'] ?: '',
            'publish_time' => transformerDate($item['publish_time']) ?: '',
            'status' => $item['status'] ?: '',
            'content' => $item['content'] ?: '',
        ];
    }
}
