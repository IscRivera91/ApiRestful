<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $buyers = Buyer::query()->get();
        return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(Buyer $buyer): JsonResponse
    {
        return $this->showOne($buyer);
    }

}
