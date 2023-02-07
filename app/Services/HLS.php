<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentException;
use App\Services\Traits\Formats;
use App\Services\Traits\Representations;
use App\Services\File;
use FFMpeg\Exception\ExceptionInterface;
use App\Services\CommandBuilder;
use App\Services\Exception\RuntimeException;

class HLS
{
    use Formats, Representations;

    /**
     * @var string
     */
    protected $path;
    /**
     * @var Media
     */
    protected $media;

    /**
     * Streaming constructor.
     * @param Media $media
     */
    public function __construct(Media $media)
    {
        $this->reps = new RepsCollection();
        $this->media = $media;
    }


    /**
     * @throws InvalidArgumentException
     */
    public function save(string $path = null, array $clouds = [])
    {
        $this->paths($path);
        $this->run();

    }


    /**
     * @throws InvalidArgumentException
     */
    protected function paths(?string $path): void
    {
        if (!is_null($path)) {
            if (strlen($path) > PHP_MAXPATHLEN) {
                throw new InvalidArgumentException("The path is too long");
            }
            File::makeDir(dirname($path));
            $this->path = $path;
        }
    }

    /**
     * Run FFmpeg to package media content
     */
    private function run(): void
    {
//        $this->media->addFilter($this->getFilter());

        $commands = (new CommandBuilder($this->media, $this->format))->build($this->format, $this->path);
        $pass = $this->format->getPasses();
        $listeners = $this->format->createProgressListener($this->media->baseMedia(), $this->media->getFFProbe(), 1, $pass);

        try {
            $this->media->getFFMpegDriver()->command($commands, false, $listeners);
        } catch (ExceptionInterface $e) {
            throw new \RuntimeException("An error occurred while saving files: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
