<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponser
{
    /***
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    private function successResponse($data, int $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    /***
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    protected function errorResponse($message, int $code): JsonResponse
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    /***
     * @param Collection $collection
     * @param int $code
     * @return JsonResponse
     */
    protected function showAll(Collection $collection, int $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    /***
     * @param Model $instance
     * @param int $code
     * @return JsonResponse
     */
    protected function showOne(Model $instance, int $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $instance], $code);
    }

}
