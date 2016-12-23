<?php

namespace ApiDemo\Models;


class GoodCollects extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_collect_goods';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

}
