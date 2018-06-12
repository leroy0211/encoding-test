<?php

namespace App\Algorithm;

/**
 * Class OffsetEncodingAlgorithm
 */
class OffsetEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * Lookup string
     */
    const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var int
     */
    private $offset;

    /**
     * @param int $offset
     */
    public function __construct($offset = 13)
    {
        $this->offset = $offset;
    }

    /**
     * Encodes text by shifting each character (existing in the lookup string) by an offset (provided in the constructor)
     * Examples:
     *      offset = 1, input = "a", output = "b"
     *      offset = 2, input = "z", output = "B"
     *      offset = 1, input = "Z", output = "a"
     *
     * @param string $text
     * @return string
     */
    public function encode($text)
    {
        if (0 === $this->offset) {
            return $text;
        }

        if (0 === $this->offset % strlen(self::CHARACTERS)) {
            return $text;
        }

        $result = '';

        foreach (str_split($text) as $letter) {
            $result .= $this->convertLetter($letter);
        }

        return $result;
    }

    /**
     * @param string $letter
     * @return string
     */
    private function convertLetter($letter)
    {
        if (empty($letter)) {
            return $letter;
        }

        $position = strpos(self::CHARACTERS, $letter);

        if (false === $position) {
            return $letter;
        }

        $offset = ($position + $this->offset) % strlen(self::CHARACTERS);

        return self::CHARACTERS[$offset];
    }

}