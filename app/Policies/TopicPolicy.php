<?php

namespace App\Policies;


use App\Models\Topic;
use App\User;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        //权限控制  只有当话题关联作者的 ID 等于当前登录用户 ID 时候才放行
         return $topic->user_id == $user->id;
//        return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        return true;
    }
}
