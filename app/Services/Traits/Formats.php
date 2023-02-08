<?php

namespace App\Services\Traits;

use App\Services\Format\StreamFormat;
use App\Services\Format\X264;
use App\Services\HLS;
use FFMpeg\Format\VideoInterface;
use App\Services\Format\HEVC;

trait Formats
{
    /**
     * @var VideoInterface
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
     * @param string $video_codec
     * @param string|null $audio_codec
     * @param bool $default_init_opts
     * @return Formats
     */
    public function hevc(string $video_codec = 'libx265', string $audio_codec = 'aac', bool $default_init_opts = true)
    {
        $this->setFormat(new HEVC($video_codec, $audio_codec, $default_init_opts));
        return $this;
    }

    /**
     * @param VideoInterface $format
     * @return HLS
     */
    public function setFormat(VideoInterface $format): HLS
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return VideoInterface
     */
    public function getFormat(): VideoInterface
    {
        return $this->format;
    }
}
