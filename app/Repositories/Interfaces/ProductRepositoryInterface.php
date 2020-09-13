<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public  function addProduct(Request $request);
}
