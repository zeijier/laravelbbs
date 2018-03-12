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
function make_excerpt($value,$length = 200){
    //  试试$value中匹配正则的用空格 替换
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/',' ',strip_tags($value)));
    return str_limit($excerpt,$length);
}