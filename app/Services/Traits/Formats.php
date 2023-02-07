<?php

namespace App\Services\Traits;

use App\Services\Format\X264;
use App\Services\HLS;

trait Formats
{
    /**
     * @var mixed
     */
    protected $format;

    /**
     * @param string $video_codec
     * @param string $audio_codec
     * @param bool $default_init_opts
     * @return HLS
     */
    public function x264(string $video_codec = 'libx264', string $audio_codec = 'aac', bool $default_init_opts = true): HLS
    {
        $this->setFormat(new X264($video_codec, $audio_codec, $default_init_opts));
        return $this;
    }

    /**
     * @param mixed $format
     *
     */
    public function setFormat($format): HLS
    {
        $this->format = $format;
        return $this;
    }
}
