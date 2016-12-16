<?php

namespace ApiDemo\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ECUser extends BaseModel implements AuthenticatableContract, JWTSubject
{
    // 用户验证attempt
    use  Authenticatable;

    protected $connection = 'b2c';
    protected $table = 'ecs_users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;


    // 查询用户的时候，不暴露密码
    protected $hidden = ['password'];

    // jwt 需要实现的方法
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // jwt 需要实现的方法
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function collects(){
        return $this->belongsToMany('ApiDemo\Models\Goods','ecs_collect_goods','user_id','goods_id');
    }
}
