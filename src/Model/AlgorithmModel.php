<?php

namespace App\Model;


class AlgorithmModel
{
    /** @var string */
    private $input;

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param string $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

}
