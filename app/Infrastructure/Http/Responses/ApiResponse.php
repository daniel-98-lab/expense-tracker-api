<?php

namespace App\Infrastructure\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse 
{
    /**
     * Generate a successful response.
     *
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(mixed $data = null, int $status = 200): JsonResponse
    {
        return response()->json($data ? ['data' => $data] : ['message' => 'Success'], $status);
    }

    /**
     * Generate a JSON:API formatted response for a single resource.
     *
     * @param string $type
     * @param int|string $id
     * @param array $attributes
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successResource(string $type, int|string $id, array $attributes, int $statusCode = 200)
    {
        return response()->json([
            'data' => [
                'type'       => $type,
                'id'         => (string) $id,
                'attributes' => $attributes,
            ]
        ], $statusCode);
    }

    /**
     * Generate a JSON:API formatted response for multiple resources.
     *
     * @param string $type
     * @param array $items
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successCollection(string $type, array $items, int $statusCode = 200)
    {
        return response()->json([
            'data' => array_map(fn($item) => [
                'type'       => $type,
                'id'         => (string) $item['id'],
                'attributes' => $item,
            ], $items)
        ], $statusCode);
    }

    /**
     * Generate an error response following JSON:API standards.
     *
     * @param string $title
     * @param string $detail
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(string $title, string $detail, int $status = 400): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'status' => (string) $status,
                    'title' => $title,
                    'detail' => $detail,
                ]
            ]
        ], $status);
    }
}