<?php

namespace ApiDemo\Models;


class GoodImg extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_goods_gallery';
    protected $primaryKey = 'img_id';
    public $timestamps = false;

}
