<?php

namespace ApiDemo\Models;


class SellerShopInfo extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_seller_shopinfo';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
