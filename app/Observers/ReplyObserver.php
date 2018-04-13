<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    //监控created 事件，
//我们监控 created 事件，当 Elequont 模型数据成功创建时，created 方法将会被调用。
    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count',1);
    }

    public function creating(Reply $reply)
    {
        //  clean  话题回复的内容限定与话题的内容无异，因此我们使用同样的过滤规则 —— user_topic_body 。
        //  过滤xss
        $reply->content = clean($reply->content,'user_topic_body');
    }
}