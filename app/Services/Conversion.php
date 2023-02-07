<?php

namespace App\Services;

use FFMpeg\Exception\ExceptionInterface;

class Conversion
{
    protected static $ffmpeg;

    /**
     * @return void
     */
    public function __construct()
    {
        self::$ffmpeg = \App\Services\FFMpeg::create();
    }

    /**
     * @return FFMpeg
     */
    public function make(): FFMpeg
    {
        return  self::$ffmpeg;
    }


}
