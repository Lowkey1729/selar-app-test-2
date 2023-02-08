<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentException;
use App\Services\Traits\Formats;
use App\Services\Traits\Representations;
use App\Services\File;
use FFMpeg\Exception\ExceptionInterface;
use App\Services\CommandBuilder;
use FFMpeg\Format\VideoInterface;
use App\Services\Filters\HLSFilter;
use App\Services\Filters\StreamFilterInterface;


class HLS implements StreamInterface
{
    use Formats, Representations;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    protected $path;
    /**
     * @var Media
     */
    protected $media;

    /** @var string */
    private $strict = "-2";

    /** @var array */
    private $additional_params = [];

    /** @var bool */
    private $tmp_key_info_file = false;


    /** @var string */
    private $hls_base_url = "";

    /** @var string */
    private $hls_segment_type = 'mpegts';

    /** @var string */
    private $hls_key_info_file = "";


    /** @var int */
    private $hls_list_size = 0;


    /** @var string */
    private $hls_time = 10;

    /** @var bool */
    private $hls_allow_cache = true;

    /** @var string */
    private $hls_fmp4_init_filename = "init.mp4";

    /** @var array */
    private $flags = [];


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
        $this->media->addFilter($this->getFilter());

        $commands = (new CommandBuilder($this->media, $this->format))
            ->build($this->format, $this->path);
        $pass = $this->format->getPasses();
        $listeners = $this->format->createProgressListener($this->media->baseMedia(), $this->media->getFFProbe(), 1, $pass);


        try {
            $this->media->getFFMpegDriver()->command($commands, false, $listeners);
        } catch (ExceptionInterface $e) {
            throw new \RuntimeException("An error occurred while saving files: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param VideoInterface $format
     * @return array
     */
    protected function getFormatOptions(VideoInterface $format): array
    {
        $basic = $this->arrayToFFmpegOpt([
            'c:v' => $format->getVideoCodec(),
            'c:a' => $format->getAudioCodec(),
        ]);

        $options = $this->arrayToFFmpegOpt(
            array_merge($format->getAdditionalParameters() ?? [])
        );

        return array_merge($basic, $options);
    }

    /**
     * @param array $array
     * @param string $start_with
     * @return array
     */
    public static function arrayToFFmpegOpt(array $array, string $start_with = "-"): array
    {
        $new = [];
        foreach ($array as $key => $value) {
            if (is_string($key)) {
                array_push($new, $start_with . $key, $value);
            } else {
                $new = null;
                break;
            }
        }

        return $new ?? $array;
    }

    /**
     * @return HLSFilter
     */
    protected function getFilter(): StreamFilterInterface
    {
        return new HLSFilter($this);
    }

    public function getMedia(): Media
    {
        return $this->media;
    }

    public function pathInfo(int $option): string
    {
        return pathinfo($this->path, $option);
    }

    public function live(string $url): void
    {
        // TODO: Implement live() method.
    }

    /**
     * @return int
     */
    public function getHlsListSize(): int
    {
        return $this->hls_list_size;
    }


    /**
     * @return string
     */
    public function getHlsTime(): string
    {
        return $this->hls_time;
    }

    /**
     * @param string $hls_time
     * @return HLS
     */
    public function setHlsTime(string $hls_time): HLS
    {
        $this->hls_time = $hls_time;
        return $this;
    }

    /**
     * @return string
     */
    public function getSegSubDirectory(): ?string
    {
        return $this->seg_sub_directory;
    }

    /**
     * @return string
     */
    public function getHlsBaseUrl(): ?string
    {
        return $this->hls_base_url;
    }

    /**
     * @return bool
     */
    public function isHlsAllowCache(): bool
    {
        return $this->hls_allow_cache;
    }

    /**
     * @param bool $hls_allow_cache
     * @return HLS
     */
    public function setHlsAllowCache(bool $hls_allow_cache): HLS
    {
        $this->hls_allow_cache = $hls_allow_cache;
        return $this;
    }

    /**
     * @return HLS
     */
    public function fragmentedMP4(): HLS
    {
        $this->setHlsSegmentType("fmp4");
        return $this;
    }

    /**
     * @param string $hls_segment_type
     * @return HLS
     */
    public function setHlsSegmentType(string $hls_segment_type): HLS
    {
        $this->hls_segment_type = $hls_segment_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getHlsSegmentType(): string
    {
        return $this->hls_segment_type;
    }

    /**
     * @param string $hls_fmp4_init_filename
     * @return HLS
     */
    public function setHlsFmp4InitFilename(string $hls_fmp4_init_filename): HLS
    {
        $this->hls_fmp4_init_filename = $hls_fmp4_init_filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getHlsFmp4InitFilename(): string
    {
        return $this->hls_fmp4_init_filename;
    }

    /**
     * @param array $flags
     * @return HLS
     */
    public function setFlags(array $flags): HLS
    {
        $this->flags = array_merge($this->flags, $flags);
        return $this;
    }

    /**
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags;
    }

    /**
     * @return string
     */
    public function getHlsKeyInfoFile(): string
    {
        return $this->hls_key_info_file;
    }


    /**
     * @return array
     */
    public function getAdditionalParams(): array
    {
        return $this->additional_params;
    }

    /**
     * Clear key info file if is a temp file
     */
    public function __destruct()
    {
        if ($this->tmp_key_info_file) {
            File::remove($this->getHlsKeyInfoFile());
        }

    }

    /**
     * @param string $strict
     * @return HLSFilter
     */
    public function setStrict(string $strict): HLSFilter
    {
        $this->strict = $strict;
        return new HLSFilter($this);
    }

    /**
     * @return string
     */
    public function getStrict(): string
    {
        return $this->strict;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }


}
