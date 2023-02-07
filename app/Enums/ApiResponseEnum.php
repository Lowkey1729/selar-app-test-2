<?php


namespace App\Enums;


use JetBrains\PhpStorm\ArrayShape;

/**
 * @method static self statusPending()
 * @method static self statusFailed()
 * @method static self statusSuccess()
 */
class ApiResponseEnum extends \Spatie\Enum\Enum
{

    protected static function values(): array
    {
        return [
            'statusPending' => 'pending',
            'statusFailed' => 'failed',
            'statusSuccess' => 'success',
        ];
    }
}
