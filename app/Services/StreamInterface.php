<?php


namespace App\Services;


use FFMpeg\Format\VideoInterface;

interface StreamInterface
{
    /**
     * @return Media
     */
    public function getMedia(): Media;

    /**
     * @return VideoInterface
     */
    public function getFormat(): VideoInterface;

    /**
     * @param int $option
     * @return string
     */
    public function pathInfo(int $option): string;

    /**
     * @param string|null $path
     * @param array $clouds
     * @return mixed
     */
    public function save(string $path = null, array $clouds = []);

    /**
     * @param string $url
     */
    public function live(string $url): void;
}
