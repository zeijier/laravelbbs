<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-03-05/0005
 * Time: 22:43
 */

//此方法会将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
function route_class(){
//    将 . 替换成 -
    return str_replace('.','-',Route::currentRouteName());
}