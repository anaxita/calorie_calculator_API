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

        $count_days = $this->collection['days'];

        $data = $this->collection['products']->reduce( // Массив даты-калории для графика 
            function ($arr, $item) {

                $arr['dates'][] = date('d-m-Y', strtotime($item->created_at));
                $arr['calories'][] = $item->calorie_total;

                return $arr;
            },
            ['dates' => [], 'calories' => []]
        );

        $count_products = $this->collection['products']->count(); // Количество продуктов
        $product_num_sum = $this->collection['products']->sum('product_num'); // Сумма грамм
        $avg_products = round($count_products / $count_days); // Среднее количество продуктов в день

        $calorie_sum = $this->collection['products']->sum('calorie_total'); // Сумма калорий
        $avg_calories = round($this->collection['products']->avg('calorie_total')); // Среднее количество калорий в день

        $biggest_product = $this->collection['products']->sortByDesc('calorie_total')->first(); //Самый высококалорийный продукт
        $biggest_product_name = $biggest_product->name; //
        $biggest_product_calorie_total = $biggest_product->calorie_total; // 

        $smallest_product = $this->collection['products']->sortBy('calorie_total')->first(); // Самый низкокалорийный продукт
        $smallest_product_name = $smallest_product->name; //
        $smallest_product_calorie_total = $smallest_product->calorie_total; //

        return [
            'data' => $data,
            'count_days' => $count_days,
            'count_products' => $count_products,
            'product_num_sum' => $product_num_sum,
            'avg_products' => $avg_products,
            'calorie_sum' => $calorie_sum,
            'avg_calories' => $avg_calories,
            'biggest_product' => [
                'name' => $biggest_product_name,
                'calorie_total' => $biggest_product_calorie_total
            ],
            'smallest_product' => [
                'name' => $smallest_product_name,
                'calorie_total' => $smallest_product_calorie_total
            ],
        ];
    }
}
