<?php

namespace App\Actions;

use App\Exceptions\InvalidArgumentException;
use App\Services\Conversion;
use App\Services\Representation;

class VideoConverterAction
{

    /**
     * @var
     */
    public $HLSConverter;
    /**
     * @var string
     */
    protected $setUup;

    public static function make(): self
    {
        return new static();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function __construct()
    {

        $this->handle();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function handle()
    {
        $r_480p = (new Representation())->setKiloBitrate(750)->setResize(854, 480);
        $r_720p = (new Representation())->setKiloBitrate(2048)->setResize(1280, 720);
        $conversion = new Conversion();
        $conversion
            ->make()
            ->open(url('/video2.mp4'), ['analyzeduration' => '100M',
                'probesize' => '100M'])
            ->hls()
            ->x264()
            ->addRepresentations([$r_480p, $r_720p])
            ->save('./public/selar-converts/hls-converted.ts');
    }
}
