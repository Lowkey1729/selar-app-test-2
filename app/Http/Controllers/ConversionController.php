<?php

namespace App\Http\Controllers;

use App\Actions\VideoConverterAction;
use App\Events\VideoConverter;
use App\Exceptions\InvalidArgumentException;
use App\Helpers\ApiResponse;
use App\Services\Conversion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function convert(): JsonResponse
    {
        dispatch(static function ()  {
            return VideoConverterAction::make();
        });
        return ApiResponse::success('File converting to HlS. Please wait...');


    }
}
