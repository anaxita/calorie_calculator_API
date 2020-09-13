<?php

namespace App\Http\Resources;

use App\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return $this->collection->map(function (Product $v) {
            return [
                'id' => $v->id,
                'name' => $v->name,
                'product_num' => $v->product_num,
                'calorie_num' => $v->calorie_num,
                'counting_type' => $v->counting_type,
                'calorie_total' => $v->calorie_total
            ];
        })->toArray();
    }
}

