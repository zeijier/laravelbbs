<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Cache;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request,CaptchaBuilder $builder){
        $key = 'captcha-'.str_random(15);
        $phone = $request->phone;
//        controller 中，注入CaptchaBuilder，通过它的 build 方法，创建出来验证码图片
        $captcha = $builder->build();
        $expiredAt = now()->addMinutes(5);
//        使用 getPhrase 方法获取验证码文本，跟手机号一同存入缓存。
        Cache::put($key,['phone'=>$phone,'code'=>$captcha->getPhrase()],$expiredAt);
        $result = [
            'captcha_key'=>$key,
            'expired_at'=>$expiredAt,
//          inline 方法获取的 base64 图片验证码
            'captcha_image_content'=>$captcha->inline()
        ];
        return $this->response->array($result)->setStatusCode(201);
    }
}
