<?php

namespace App\Algorithm;

/**
 * Class SubstitutionEncodingAlgorithm
 */
class SubstitutionEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var array
     */
    private $substitutions;

    /**
     * SubstitutionEncodingAlgorithm constructor.
     * @param $substitutions
     */
    public function __construct(array $substitutions)
    {
        $this->substitutions = $substitutions;
    }

    /**
     * Encodes text by substituting character with another one provided in the pair.
     * For example pair "ab" defines all "a" chars will be replaced with "b" and all "b" chars will be replaced with "a"
     * Examples:
     *      substitutions = ["ab"], input = "aabbcc", output = "bbaacc"
     *      substitutions = ["ab", "cd"], input = "adam", output = "bcbm"
     *
     * @param string $text
     * @return string
     */
    public function encode($text)
    {
        $replaces = [];

        foreach ($this->substitutions as $pattern) {
            $split = str_split($pattern);
            $replaces[mb_strtolower($split[0])] = mb_strtolower($split[1]);
            $replaces[mb_strtolower($split[1])] = mb_strtolower($split[0]);
            $replaces[mb_strtoupper($split[0])] = mb_strtoupper($split[1]);
            $replaces[mb_strtoupper($split[1])] = mb_strtoupper($split[0]);
        }

        $result = '';

        foreach (str_split($text) as $letter) {
            $result .= $replaces[$letter] ?? $letter;
        }

        return $result;
    }

}