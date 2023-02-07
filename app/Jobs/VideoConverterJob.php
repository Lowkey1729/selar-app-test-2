<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VideoConverterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    public $HLSConverter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($HLSConverter)
    {
        $this->HLSConverter = $HLSConverter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->HLSConverter
            ->open(url('/test.mp4'))
            ->hls()
            ->x264()
            ->addRepresentations([480, 720])
            ->save('/var/media/hls-stream.ts');
    }
}
