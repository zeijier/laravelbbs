<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;

//通过 artisan 创建出来的控制器，默认会继承 App\Http\Controllers\Controller，我们只需要删除 use App\Http\Controllers\Controller 这一行即可，这样会继承相同命名空间下的 Controller，也就是我们上一步中添加的那个控制器。
//use App\Http\Controllers\Controller;

class VerificationCodesController extends Controller
{
//    短信验证码
    public function store(VerificationCodeRequest $request,EasySms $easySms)
    {
        $phone = $request->phone;
//        本地环境不发送真实短信，
        if (!app()->environment('production')) {
            $code = '1234';
            $key = 'test_' . str_random(15);
            $expiredAt = now()->addMinutes(10);
            Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
            return $this->response->array([
                'key' => $key,
                'expired_at' => $expiredAt->toDateTimeString(),
            ])->setStatusCode(201);
        } else {
//        生成4位随机数
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send($phone, [
                    'template' => '77778',
                    'data' => [
                        'code' => "{$code}"
                    ]
                ]);
            } catch (ClientException $exception) {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['reason'] ?? '短信发送异常！');
            }
            $key = 'verificationCode_' . str_random(15);
            $expiredAt = now()->addMinutes(10);
            Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
            return $this->response->array([
                'key' => $key,
                'expired_at' => $expiredAt->toDateTimeString(),
            ])->setStatusCode(201);
        }
    }
}
