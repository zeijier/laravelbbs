<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
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
}
