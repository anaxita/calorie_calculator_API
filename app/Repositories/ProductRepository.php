<?php


namespace App\Repositories;


use App\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:20',
            'product_num' => 'required|int',
            'calorie_num' => 'required|int',
            'counting_type' => 'required'
        ]);
        $user = $request->user(); //Получаем пользователя из токена

        if ($request->get('counting_type')) { // высчитываем количество калорий в зависимости от типа
            $calorie_total = $request->get('calorie_num');
        } else {
            $calorie_total = $request->get('product_num') * $request->get('calorie_num') / 100; // a * b / 100
        }

        return  Product::create([ //Добавляем продукт в БД и айди юзера в поле user_id
            'name' => $request->get('name'),
            'product_num' => $request->get('product_num'),
            'calorie_num' => $request->get('calorie_num'),
            'counting_type' => $request->get('counting_type'),
            'calorie_total' => round($calorie_total),
            'user_id' => $user->id
        ]);

    }
}
