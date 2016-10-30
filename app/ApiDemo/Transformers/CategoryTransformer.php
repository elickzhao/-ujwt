<?php

namespace ApiDemo\Transformers;

use ApiDemo\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $Category)
    {
        return $Category->attributesToArray();
    }
}
