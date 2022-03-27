<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $Products = Product::all();
        return  $this->showAll($Products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return $this->showOne($product);
    }
}
