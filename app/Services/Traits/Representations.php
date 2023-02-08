<?php

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
