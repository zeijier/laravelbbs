<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;


trait LastActivedAtHelper{
    // 缓存相关
    protected $hash_prefix = 'laravel_last_at';
    protected $field_prefix = 'user_';
    public  function recordLastActived(){
        //获取今天的日期
        $date = Carbon::now()->toDateString();
        //redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        $hash = $this->hash_prefix.$date;
        // 字段名称，如：user_1
        $field = $this->field_prefix.$this->id;
        //测试获取哈希表后名称后，使用hGetAll 获取哈希表全部的数据
        //dd(Redis::hGetAll($hash));
        // 当前时间，如：2017-10-21 08:35:15
        $now = Carbon::now()->toDateTimeString();
        // 数据写入 Redis ，字段已存在会被更新
        Redis::hSet($hash,$field,$now);
    }

    public function syncUserActivedAt(){
        // 获取昨天的日期，格式如：2017-10-21
        $yesterday_date = Carbon::yesterday()->toDateString();
        //获取昨天 Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        $hash = $this->hash_prefix.$yesterday_date;
        // 从 Redis 中获取所有哈希表里的数据
        $dates = Redis::hGetAll($hash);
        foreach ($dates as $user_id =>$actived_at){
            //得到user id
            $user_id = str_replace($this->field_prefix,'',$user_id);
            //只有当用户存在时才更新到数据库中
            if ($user = $this->find($user_id)){
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }
        //保存到数据库后把昨天的删除掉
        Redis::del($hash);
    }
}