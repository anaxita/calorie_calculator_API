<?php


namespace App\Repositories;


use App\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    public function addProduct(Request $request)
    {
        $user = $request->user(); //Получаем пользователя из токена

        if ($request->get('counting_type')) { // высчитываем количество калорий в зависимости от типа
            $calorie_total = $request->get('calorie_num');
        } else {
            $calorie_total = $request->get('product_num') * $request->get('calorie_num') / 100; // a * b / 100
        }

        $newProduct = Product::create([ //Добавляем продукт в БД и айди юзера в поле user_id
            'name' => $request->get('name'),
            'product_num' => $request->get('product_num'),
            'calorie_num' => $request->get('calorie_num'),
            'counting_type' => $request->get('counting_type'),
            'calorie_total' => round($calorie_total),
            'user_id' => $user->id
        ]);

        return $newProduct;
    }
}
