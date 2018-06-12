<?php

namespace Tests\App;

use PHPUnit\Framework\TestCase;

/**
 * Class CompositeEncodingAlgorithmTest
 */
class CompositeOffsetSubstitutionEncodingAlgorithmTest extends TestCase
{
    /**
     * @dataProvider getTexts
     * @param $offset
     * @param $text
     * @param $encoded
     */
    public function testValidEncoding($offset, $text, $encoded)
    {
        $algorithm = new \App\Algorithm\CompositeEncodingAlgorithm();

        $algorithm->add(new \App\Algorithm\OffsetEncodingAlgorithm($offset));
        $algorithm->add(new \App\Algorithm\SubstitutionEncodingAlgorithm(array('ga', 'de', 'ry', 'po', 'lu', 'ki')));

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return array(
            array(0, '', ''),
            array(0, 'abc', 'gbc'),
            array(1, 'abc', 'bce'),
            array(1, 'abc def, ghi.', 'bce dfa, hkj.'),
            array(26, 'abc def.', 'GBC EDF.'),
            array(26, 'ABC DEF.', 'gbc edf.'),
        );
    }

    /**
     * @dataProvider getReversedTexts
     * @param $offset
     * @param $text
     * @param $encoded
     */
    public function testReverseOrder($offset, $text, $encoded)
    {
        $algorithm = new \App\Algorithm\CompositeEncodingAlgorithm();

        $algorithm->add(new \App\Algorithm\SubstitutionEncodingAlgorithm(array('ga', 'de', 'ry', 'po', 'lu', 'ki')));
        $algorithm->add(new \App\Algorithm\OffsetEncodingAlgorithm($offset));

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @return array
     */
    public function getReversedTexts()
    {
        return array(
            array(0, 'abc', 'gbc'),
            array(1, 'abc', 'hcd'),
            array(1, 'abc def, ghi.', 'hcd feg, bil.')
        );
    }
}