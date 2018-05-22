<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationloginRequest;
use App\Http\Requests\Api\AuthorizationRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthorizationController extends Controller
{
//    TODO  ！！ 第三方登录
    public function socialStore($type, AuthorizationRequest $request)
    {
        if (!in_array($type, ['weixin'])) {
            return $this->response->errorBadRequest();
        }
        $driver = Socialite::driver($type);
        try {
            if ($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
//                print_r($code);die;
                $token = array_get($response, 'access_token');
            } else {
                $token = $request->access_token;
                if ($type == 'weixin') {
                    $driver->setOpenId($request->openid);
                }
            }

            $oauthUser = $driver->userFromToken($token);
        } catch (\Exception $e) {
            return $this->response->errorUnauthorized('参数错误，未获取用户信息');
        }

        switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }

        return $this->response->array(['token' => $user->id]);
    }

//    登录
    public function store(AuthorizationloginRequest $request){
        $username = $request->username;
        filter_var($username,FILTER_VALIDATE_EMAIL)?
            $credentials['email'] = $username:
            $credentials['phone'] = $username;
        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)){
            return $this->response->errorUnauthorized('用户名或密码错误');
        }
        return $this->response->array([
            'access_token'=>$token,
            'token_type'=>'Bearer',
//            单位是秒 *60 是一个小时
            'expires_in'=>Auth::guard('api')->factory()->getTTl()*60,
        ])->setStatusCode(201);
    }
}
