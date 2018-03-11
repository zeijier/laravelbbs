<?php

namespace App\Models;

use App\Category;
use App\User;

class Topic extends Model
{
//    protected $table = 'topics';
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
//category—— 一个话题属于一个分类；

    //要用public修饰！！！
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //user —— 一个话题拥有一个作者。
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
