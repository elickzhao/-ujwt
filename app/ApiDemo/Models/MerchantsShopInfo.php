<?php

namespace ApiDemo\Models;


class MerchantsShopInfo extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_merchants_shop_information';
    protected $primaryKey = 'shop_id';
    public $timestamps = false;

}
