<?php


namespace App\Repositories;


use App\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Carbon\Carbon;
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

    public function editProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:20',
            'product_num' => 'required|int|min:1|max:10000',
            'calorie_num' => 'required|int|min:1|max:10000',
            'counting_type' => 'required|bool'
        ]);

        if ($request->get('counting_type')) { // высчитываем количество калорий в зависимости от типа
            $calorie_total = $request->get('calorie_num');
        } else {
            $calorie_total = $request->get('product_num') * $request->get('calorie_num') / 100; // a * b / 100
        }

        $product->update([
            'name' => $request->get('name'),
            'product_num' => $request->get('product_num'),
            'calorie_num' => $request->get('calorie_num'),
            'counting_type' => $request->get('counting_type'),
            'calorie_total' => round($calorie_total),
        ]);

        return $calorie_total;
    }

    public function getStatistic($user, $start_date, $end_date)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $end_date)->setTime(23, 59, 59);
        return $user->products()->whereBetween('created_at', [$start_date, $end_date])->get();
    }
}
