<?php

namespace App\Services;

use FFMpeg\Media\Audio;
use FFMpeg\Media\MediaTypeInterface;
use FFMpeg\Media\Video;
use FFMpeg\Media\Video as BMedia;

/** @mixin  BMedia */
class Media
{

    /** @var BMedia */
    private $media;

    /** @var bool */
    private $is_tmp;
    /**
     * @var array
     */
    protected $input_options;


    /**
     * Media constructor.
     * @param MediaTypeInterface $media
     * @param bool $is_tmp
     * @param array $input_options
     */
    public function __construct(MediaTypeInterface $media, bool $is_tmp, array $input_options = [])
    {
        $this->media = $media;
        $this->is_tmp = $is_tmp;
        $this->input_options = $input_options;
    }


    /**
     * @return HLS
     */
    public function hls(): HLS
    {
        return new HLS($this);
    }


    /**
     * @return bool
     */
    public function isTmp(): bool
    {
        return $this->is_tmp;
    }

    /**
     * @return Video | Audio
     */
    public function baseMedia(): MediaTypeInterface
    {
        return $this->media;
    }

    /**
     * @param $argument
     * @return Media | BMedia
     */
    private function isInstanceofArgument($argument)
    {
        return ($argument instanceof $this->media) ? $this : $argument;
    }

    /**
     * @param $method
     * @param $parameters
     * @return Media | BMedia
     */
    public function __call($method, $parameters)
    {
        return $this->isInstanceofArgument(
            call_user_func_array([$this->media, $method], $parameters)
        );
    }

    /**
     * @return array
     */
    public function getInputOptions(): array
    {
        return $this->input_options;
    }
}

