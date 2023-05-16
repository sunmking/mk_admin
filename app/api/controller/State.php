<?php

namespace app\api\controller;

use app\common\controller\BaseApi;
use app\common\service\StateService;
use think\App;
use think\Response;

class State extends BaseApi
{
    protected $service;

    public function __construct(App $app, StateService $service)
    {
        $this->service = $service;
        parent::__construct($app);
    }

    /**
     * list
     */
    public function index(): Response
    {
        $result = $this->service->getHomeState();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }
}
