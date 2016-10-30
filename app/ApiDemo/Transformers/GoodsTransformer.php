<?php

namespace ApiDemo\Transformers;

use ApiDemo\Models\Goods;
use League\Fractal\TransformerAbstract;

class GoodsTransformer extends TransformerAbstract
{
    public function transform(Goods $Goods)
    {
        return $Goods->attributesToArray();
    }
}
