<?php

/**
 * This file is part of the PHP-FFmpeg-video-streaming package.
 *
 * (c) Amin Yazdanpanah <contact@aminyazdanpanah.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services\Traits;


use App\Services\HLS;
use App\Services\Representation;
use App\Services\RepsCollection;

trait   Representations
{
    /** @var RepsCollection */
    protected $reps;


    /**
     * add a representation
     * @param Representation $rep
     * @return Representations
     */
    public function addRepresentation(Representation $rep)
    {
        $this->reps->add($rep);
        return $this;
    }

    /**
     * add representations using an array
     * @param array $reps
     * @return HLS
     */
    public function addRepresentations(array $reps): HLS
    {
        array_walk($reps, [$this, 'addRepresentation']);
        return $this;
    }



    /**
     * @return RepsCollection
     */
    public function getRepresentations(): RepsCollection
    {
        return $this->reps;
    }
}
