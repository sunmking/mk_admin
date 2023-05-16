<?php

namespace app\common\traits;

use think\facade\Config;
use think\response\Json;

trait ApiResponseTraits
{
    /**
     * @param  null  $Msg
     * @param  null  $Data
     */
    public function returnMsg(int $Code = 200, $Msg = null, $Data = null): array
    {
        $data = [
            'Code' => $Code,
            'Msg' => $Msg,
            'Data' => $Data,
        ];

        if (!$Msg) {
            $data['Msg'] = Config::get('code.'.$Code);
        }

        if (!$Data) {
            $data['Data'] = [];
        }

        return $data;
    }

    /**
     * 成功
     *
     * @param  null  $Msg
     * @param  null  $Data
     */
    public function jsonSuccess(int $Code = 200, $Msg = null, $Data = null): Json
    {
        return $this->jsonResponse($Code, $Msg, $Data, 'success');
    }

    /**
     * 失败
     *
     * @param  null  $Msg
     * @param  null  $Data
     */
    public function jsonFail(int $Code = 404, $Msg = null, $Data = null): Json
    {
        return $this->jsonResponse($Code, $Msg, $Data, 'fail');
    }

    /**
     * json响应
     */
    private function jsonResponse($Code, $Msg, $Data, $Status): Json
    {
        if (!$Msg) {
            $Msg = Config::get('code.'.$Code);
        }

        return json([
            'Status' => $Status,
            'Code' => $Code,
            'Msg' => $Msg,
            'Data' => $Data ?? null,
        ]);
    }
}
