<?php

namespace clyde\traits;

/**
 * Class BaseError
 */
trait ErrorTrait
{
    /**
     * 错误信息
     *
     * @var string
     */
    protected $error;

    /**
     * 设置错误信息
     */
    protected function setError(?string $error = null): bool
    {
        $this->error = $error ?: '未知错误';

        return false;
    }

    /**
     * 获取错误信息
     */
    public function getError(): string
    {
        $error = $this->error;
        $this->error = null;

        return $error;
    }
}
