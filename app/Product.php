<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 *
 * @property integer $id
 */
class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'product_num', 'calorie_num', 'counting_type', 'calorie_total', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
