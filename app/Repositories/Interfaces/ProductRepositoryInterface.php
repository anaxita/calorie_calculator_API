<?php


namespace App\Repositories\Interfaces;

use App\User;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public  function addProduct(Request $request);
    public  function getStatistic(User $user, string $start_date, string $end_date);
}
