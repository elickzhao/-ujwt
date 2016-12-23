<?php

namespace ApiDemo\Transformers;

use ApiDemo\Models\Goods;
use League\Fractal\TransformerAbstract;

class GoodsTransformer extends TransformerAbstract
{
    public function transform(Goods $goods)
    {
        //return $goods->attributesToArray();
        return [
            'goods_id'    =>  (int) $goods->goods_id,
            'goods_name' => $goods->goods_name,
            'market_price'    => $goods->market_price,
            'shop_price' =>  $goods->shop_price,
            'goods_thumb' => $goods->goods_thumb
        ];
    }

//    这么写是错的 只能是关联数据表
//    public function includeCollect(Goods $goods){
//        return [
//            'name'    =>  $goods->goods_name,
//            'market_price' => $goods->market_price,
//            'shop_price'    => (int) $goods->shop_price,
//            'id' => (int) $goods->goods_id,
//        ];
//    }
}
