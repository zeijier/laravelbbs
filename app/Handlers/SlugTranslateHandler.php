<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-03-13/0013
 * Time: 0:51
 */
namespace App\Handlers;

use Symfony\Component\HttpKernel\Client;

class SlugTranslateHandler{
    public function translate($text){
        //
        $http = new Client();
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';

    }
}