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
        // make_excerpt 是定义的辅助方法
        $topic->excerpt = make_excerpt($topic->body);
    }
}