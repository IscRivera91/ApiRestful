<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $Sellers = Seller::query()->has('products')->get();
        return response()->json(['data' => $Sellers, 'code' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $Seller = Seller::query()->has('products')->findOrFail($id);
        return response()->json(['data' => $Seller, 'code' => 200]);
    }

}
