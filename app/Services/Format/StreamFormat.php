<?php


namespace App\Services\Format;


use FFMpeg\Format\Video\DefaultVideo;
use App\Exceptions\InvalidArgumentException;

abstract class StreamFormat extends DefaultVideo
{
    /**
     * @param int $kiloBitrate
     * @return DefaultVideo|void
     * @throws InvalidArgumentException
     */
    public function setKiloBitrate($kiloBitrate)
    {
        throw new InvalidArgumentException("You can not set this option, use Representation instead");
    }

    /**
     * @param int $kiloBitrate
     * @return DefaultVideo|void
     * @throws InvalidArgumentException
     */
    public function setAudioKiloBitrate($kiloBitrate)
    {
        throw new InvalidArgumentException("You can not set this option, use Representation instead");
    }
}
