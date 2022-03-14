<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sellers = Seller::query()->get();
        return  $this->showAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(Seller $seller): JsonResponse
    {
        return $this->showOne($seller);
    }

}
