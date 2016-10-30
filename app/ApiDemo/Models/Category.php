<?php

namespace ApiDemo\Models;


class Category extends BaseModel
{
    protected $connection = 'b2c';
    protected $table = 'ecs_category';
    protected $primaryKey = 'cat_id';
    public $timestamps = false;
}
