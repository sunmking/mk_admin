<?php

namespace app\common\service;

use app\Request;
use think\facade\Db;

class StateService extends BaseService
{
    protected $request;

    protected $salesIntentionModel;

    protected $acquirerOrderModel;

    protected $userModel;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getHomeState(): array
    {
        $data = [
            'state_data' => [],
            'sys_data' => $this->get_sys_info(),
        ];

        return $this->returnMsg(200, '请求成功', $data);
    }

    /**
     * 服务器信息
     */
    private function get_sys_info(): array
    {
        $sys_info['os'] = PHP_OS;
        $sys_info['zlib'] = function_exists('gzclose') ? 'YES' : '<font color="red">NO（请开启 php.ini 中的php-zlib扩展）</font>'; //zlib
        $sys_info['safe_mode'] = (bool) ini_get('safe_mode') ? 'YES' : 'NO'; //safe_mode = Off
        $sys_info['timezone'] = function_exists('date_default_timezone_get') ? date_default_timezone_get() : 'no_timezone';
        $sys_info['curl'] = function_exists('curl_init') ? 'YES' : '<font color="red">NO（请开启 php.ini 中的php-curl扩展）</font>';
        $web_server = $_SERVER['SERVER_SOFTWARE'];
        if (stristr($web_server, 'apache')) {
            $web_server = 'apache';
        } elseif (stristr($web_server, 'nginx')) {
            $web_server = 'nginx';
        } elseif (stristr($web_server, 'iis')) {
            $web_server = 'iis';
        }
        $sys_info['web_server'] = $web_server;
        $sys_info['phpv'] = phpversion();
        $sys_info['ip'] = request()->ip();
        $sys_info['postsize'] = @ini_get('file_uploads') ? ini_get('post_max_size') : '未知';
        $sys_info['fileupload'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '未开启';
        $sys_info['max_ex_time'] = @ini_get('max_execution_time').'s'; //脚本最大执行时间
        $sys_info['set_time_limit'] = function_exists('set_time_limit');
        $sys_info['domain'] = $_SERVER['HTTP_HOST'];
        $sys_info['memory_limit'] = ini_get('memory_limit');
        $mysqlinfo = Db::query('SELECT VERSION() as version');
        $sys_info['mysql_version'] = $mysqlinfo[0]['version'];
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $sys_info['gdinfo'] = $gd['GD Version'];
        } else {
            $sys_info['gdinfo'] = '未知';
        }
        if (extension_loaded('zip')) {
            $sys_info['zip'] = 'YES';
        } else {
            $sys_info['zip'] = '<font color="red">NO（请开启 php.ini 中的php-zip扩展）</font>';
        }
        $sys_info['curent_version'] = 'v1.0'; //当前程序版本
        $sys_info['web_name'] = 'yh_cms';

        return $sys_info;
    }
}
