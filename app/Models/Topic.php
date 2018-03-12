<?php

namespace App\Models;

use App\Category;
use App\User;

class Topic extends Model
{
//    protected $table = 'topics';
    protected $fillable = ['title', 'body', 'category_id', 'order', 'excerpt', 'slug'];
//category—— 一个话题属于一个分类；

    //要用public修饰！！！
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //user —— 一个话题拥有一个作者。
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function scopeWithOrder($query,$order){
        //不同的排序，使用不同的数据读取逻辑
        switch ($order){
            case 'recent':
                $query = $this->recent();
                break;
            default:
                $query = $this->recentReplied();
                break;
        }
        //预加载
        return $query->with('user','category');
    }
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at','desc');
    }
    public function scopeRecentReplied($query){
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }
}
