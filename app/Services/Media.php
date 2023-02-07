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
     * Media constructor.
     * @param MediaTypeInterface $media
     * @param bool $is_tmp
     */
    public function __construct(MediaTypeInterface $media, bool $is_tmp)
    {
        $this->media = $media;
        $this->is_tmp = $is_tmp;
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

}

