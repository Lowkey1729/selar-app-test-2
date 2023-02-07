<?php


namespace App\Helpers;


use App\Enums\ApiResponseEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApiResponse
{

    public static function success($message = '', $data = null, $renameDataTo = 'data', $showEmptyData = false): JsonResponse
    {
        $response_array = ['status' => 'success'];
        $message ? $response_array['message'] = $message : '';
        $response_array['result'] = [
            'data' => $data ?? null
        ];

        return response()->json($response_array);
    }

    public static function pending($message = '', $data = null, $renameDataTo = 'data', $showEmptyData = false): JsonResponse
    {
        $response_array = ['status' => 'pending'];
        $message ? $response_array['message'] = $message : '';
        $response_array['result'] = [
            'data' => $data ?? null
        ];

        return response()->json($response_array);
    }


    public static function failed($message = '', $data = null, $renameDataTo = 'data', $statusCode = 200): JsonResponse
    {
        $response_array = ['status' => 'failed',];
        $message ? $response_array['message'] = $message : '';
        $response_array['result'] = [
            'data' => $data ?? null
        ];

        return response()->json($response_array, $statusCode);
    }

    public static function exceptionResponse(\Exception $exception): JsonResponse
    {
        Log::info($exception->getMessage());
        return response()->json([
            'status' => ApiResponseEnum::statusFailed()->value,
            'message' => 'An unexpected error was encountered. Please contact the Admin.',
            'result' => [
                'data' => null
            ],
//            'error' => $exception->getMessage(),
            'error' => "Please contact the Admin."
        ], 500);
    }
}
