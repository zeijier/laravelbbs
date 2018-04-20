<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function root(){
        return view('pages.root');
    }
    public function permissionDenied(){
        //如果当前用户有权限访问后台，直接跳转访问
        // 因为administrator中permission是一个函数，里面得到的是一个对象，所有加() 得到值
        if (config('administrator.permission')()){
            return redirect(url(config('admin')),302);
        }
        //否则使用视图
        return view('pages.permission_denied');
    }
}
