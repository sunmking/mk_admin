<?php

declare(strict_types=1);

namespace app\common\controller;

use app\BaseController;
use app\middleware\ApiCheck;

class BaseApi extends BaseController
{
    protected $middleware = [ApiCheck::class];
}
