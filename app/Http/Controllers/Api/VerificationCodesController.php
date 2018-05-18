<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;

//通过 artisan 创建出来的控制器，默认会继承 App\Http\Controllers\Controller，我们只需要删除 use App\Http\Controllers\Controller 这一行即可，这样会继承相同命名空间下的 Controller，也就是我们上一步中添加的那个控制器。
//use App\Http\Controllers\Controller;

class VerificationCodesController extends Controller
{
//    短信验证码
    public function store(VerificationCodeRequest $request,EasySms $easySms){
        $phone = $request->phone;
//        生成4位随机数
        $code = str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);
        try{
            $result = $easySms->send($phone,[
               'content'=>"laravelBBS验证码是{$code}!"
            ]);
        }catch (ClientException $exception){

        }

    }
}
