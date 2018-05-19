<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class AuthorizationController extends Controller
{
    public function socialStore($type,AuthorizationRequest $request){
        if (!in_array($type,['weixin'])){
            return $this->response->errorBadRequest();
        }
        $driver = Socialite::driver($type);
        try{
            if ($code = $request->code){
                $response = $driver->getAccessTokenResponse($code);
                $token = array_get($response,'access_token');
            }
        }catch (\Exception $e){

        }
    }
}
