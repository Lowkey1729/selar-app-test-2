<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConvertingVideo
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $event->HLSConverter
            ->open(url('/test.mp4'))
            ->hls()
            ->x264()
            ->addRepresentations([480, 720])
            ->save('/var/media/hls-stream.ts');
    }
}
