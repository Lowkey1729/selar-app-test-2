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

    protected $representations = [];
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
        $this->setRepresentations();
        $this->handle();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function handle()
    {
        (new Conversion())
            ->make()
            ->open(url('/video2.mp4'), ['analyzeduration' => '100M',
                'probesize' => '100M'])
            ->hls()
            ->x264()
            ->addRepresentations($this->getRepresentations())
            ->save('./public/selar-converts/hls-converted.ts');
    }

    /**
     * @return array
     */
    protected function getRepresentations(): array
    {
        return $this->representations;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function setRepresentations(): void
    {
        $r_480p = (new Representation())
            ->setKiloBitrate(750)
            ->setResize(854, 480);

        $r_720p = (new Representation())
            ->setKiloBitrate(2048)
            ->setResize(1280, 720);

        $this->representations = [$r_480p, $r_720p];
    }


}
