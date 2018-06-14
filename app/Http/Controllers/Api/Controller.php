<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
//增加了 DingoApi 的 helper，这个 trait 可以帮助我们处理接口响应
    use Helpers;
}
