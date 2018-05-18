<?php

namespace App;

use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Models\Traits\ActiveUserHelper;
    use Notifiable;
    //使用 laravel-permission 提供的 Trait —— HasRoles
    //此举能让我们获取到扩展包提供的所有权限和角色的操作方法。
    use HasRoles;
    use Models\Traits\LastActivedAtHelper;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar','phone',
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

    public function setPasswordAttribute($value){
        // 不等于 60，做密码加密处理
        if (strlen($value)!=60){
            $value = bcrypt($value);
        }
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        $this->attributes['password'] =$value;
    }
    public function setAvatarAttribute($path){
// 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if (!starts_with($path,'http')){
            //拼接url
            $path = "/uploads/images/avatar/$path";
        }
        $this->attributes['avatar']= $path;
    }
}
