<?php
/**
 * Created by PhpStorm.
 * User: ricar
 * Date: 26/03/2019
 * Time: 1:29 PM
 */
namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

trait ApiResponser
{
    private function success($data, $code = 200)
    {
        return response()->json($data, $code);
    }
    protected function errorResponse($message, $code = 422)
    {
        return response()->json([
            'error' =>  $message,
            'code'  =>  $code
        ], $code);
    }
    /**
     * @param JsonResource $collection
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function collectionResponse(JsonResource $collection, int $code = 200)
    {
        return $collection->response()->setStatusCode($code);
    }
    /**
     * @param JsonResource $instance
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function singleResponse(JsonResource $instance, int $code = 200)
    {
        $instance = $this->cacheResponse($instance);
        return $instance->response()->setStatusCode($code);
    }
    protected function api_success($data, $code = 200)
    {
        return $this->success($data, $code);
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";
        return Cache::remember($fullUrl, 30 / 60, function () use ($data) {
            return $data;
        });
    }
}
