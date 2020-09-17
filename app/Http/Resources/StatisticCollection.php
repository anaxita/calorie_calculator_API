<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StatisticCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->reduce(
            function ($arr, $item) {

                $arr['dates'][] = $item->created_at->toDateString();
                $arr['calories'][] = $item->calorie_total;

                return $arr;
            },
            ['dates' => [], 'calories' => []]
        );
    }
}
