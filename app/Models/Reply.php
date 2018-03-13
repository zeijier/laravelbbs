<?php

namespace App\Models;

use App\User;

class Reply extends Model
{
    // 允许修改的字段
    protected $fillable = ['content'];
    public function topic(){
        return $this->belongsTo(Topic::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
