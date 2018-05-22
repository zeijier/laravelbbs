<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
//    第三方登录
    public function rules()
    {
        return [
            'code'=>'required_without:access_token|string',
            'access_token'=>'required_without:code|string',
        ];
        if ($this->social_type == 'weixin' && !$this->code) {
            $rules['openid']  = 'required|string';
        }
        return $rules;
    }
}
