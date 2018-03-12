<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    public function saving(Topic $topic){
        // HTMLPurifier for Laravel 5 进行xss 过滤
        $topic->body = clean($topic->body,'user_topic_body');
        // make_excerpt 是定义的辅助方法
        $topic->excerpt = make_excerpt($topic->body);
    }
}