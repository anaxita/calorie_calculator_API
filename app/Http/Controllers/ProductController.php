<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsCollection;
use App\Http\Resources\StatisticCollection;
use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->authorizeResource(Product::class, 'product');
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) //  Список продуктов /api/products GET
    {
        return \response(new ProductsCollection($request->user()->products), 200);
    }


    /**
     * Store a newly created resour ce in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // Добавить новый продукт  /api/products POST
    {
        $product = $this->productRepository->addProduct($request);
        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) // products/23 PATCH
    {
        $calorie_total = $this->productRepository->editProduct($request, $product);
        return \response(['calorie_total' => $calorie_total], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product) //products/10 DELETE
    {
        $product->delete();
        return response(['message' => 'deleted'], Response::HTTP_OK);
    }

    /**
     * Get products list by some period
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function getStatistic(Request $request)
    {
        $products = $this->productRepository->getStatistic(
            $request->user(),
            $request->get('start_date'),
            $request->get('end_date')
        );
        if (!$products) {
            return response(['no products'], Response::HTTP_OK);
        }
        return response(new StatisticCollection($products), Response::HTTP_OK);
    }
}
