<?php

namespace ApiDemo\Transformers;

use ApiDemo\Models\ECUser;
use League\Fractal\TransformerAbstract;

class ECUserTransformer extends TransformerAbstract
{
    public function transform(ECUser $ECUser)
    {
        return $ECUser->attributesToArray();
    }
}
