<?php

namespace ApiDemo\Models;


class Goods extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;
}
