<?php

namespace clyde\utils;

use think\Response;

/**
 * Json输出类
 * Class Json
 */
class Json
{
    private $code = 200;

    /**
     * @return $this
     */
    public function code(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function make(int $status, string $msg, ?array $data = null): Response
    {
        $res = compact('status', 'msg');

        if (!is_null($data)) {
            $res['data'] = $data;
        }

        return Response::create($res, 'json', $this->code);
    }

    /**
     * @param  string  $msg
     */
    public function success($msg = 'ok', ?array $data = null): Response
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = 'ok';
        }

        return $this->make(200, $msg, $data);
    }

    /**
     * @param  mixed  ...$args
     */
    public function successful(...$args): Response
    {
        return $this->success(...$args);
    }

    /**
     * @param  string  $msg
     */
    public function fail($msg = 'fail', ?array $data = null): Response
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = 'ok';
        }

        return $this->make(400, $msg, $data);
    }

    /**
     * @param  array  $result
     */
    public function status($status, $msg, $result = []): Response
    {
        $status = strtoupper($status);
        if (is_array($msg)) {
            $result = $msg;
            $msg = 'ok';
        }

        return $this->success($msg, compact('status', 'result'));
    }
}
