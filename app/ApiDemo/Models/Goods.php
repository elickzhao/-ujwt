<?php

namespace ApiDemo\Models;


class Goods extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;

    /**
     * 获取商品所有缩略图。
     */
    public function images()
    {
        return $this->hasMany('ApiDemo\Models\GoodImg');
    }

    public function shop(){
        return $this->belongsTo('ApiDemo\Models\SellerShopInfo','user_id','ru_id');
    }

    public function merchants(){
        return $this->belongsTo('ApiDemo\Models\MerchantsShopInfo','user_id','user_id');
    }
}
