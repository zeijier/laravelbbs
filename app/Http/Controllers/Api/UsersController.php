<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function store(UserRequest $request){
        $verifyData = Cache::get($request->verification_key);
        if (!$verifyData){
            return $this->response->error('验证码已失效',422);
        }
//     字符串的值是否相等
        if (!hash_equals($verifyData['code'],$request->verification_code)){
            return $this->response->errorUnauthorized('验证码错误');
        }
        $user = User::create([
            'name'=>$request->name,
            'phone'=>$verifyData['phone'],
            'password'=>bcrypt($request->password),
        ]);
        Cache::forget($request->verification_kay);
        return $this->response->created();
    }

    public function me(){
//            TODO 获取不到用户
//        dingo 的trait提供了user() 方法，获取当前登录的用户。
//        $this->user() 等同于\Auth::guard('api')->user()。
        return $this->response->item($this->user(),new UserTransformer());
    }
}
