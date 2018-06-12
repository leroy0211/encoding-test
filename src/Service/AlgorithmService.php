<?php

namespace App\Service;


use App\Algorithm\EncodingAlgorithm;

class AlgorithmService
{
    /** @var EncodingAlgorithm */
    private $encodingAlgorithm;

    /**
     * AlgorithmService constructor.
     * @param EncodingAlgorithm $encodingAlgorithm
     */
    public function __construct(EncodingAlgorithm $encodingAlgorithm)
    {
        $this->encodingAlgorithm = $encodingAlgorithm;
    }

    /**
     * @param string $text
     * @return string
     */
    public function encodeText($text)
    {
        return $this->encodingAlgorithm->encode($text);
    }

}
