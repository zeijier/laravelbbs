<?php

namespace App;

use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    //使用 laravel-permission 提供的 Trait —— HasRoles
    //此举能让我们获取到扩展包提供的所有权限和角色的操作方法。
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function topics(){
        return $this->hasMany(Topic::class);
    }
    // 一个用户有很多回复
    public function replies(){
        return $this->hasMany(Reply::class);
    }
    public function isAuthorOf($model){
        return $this->id == $model->user_id;
    }

}
