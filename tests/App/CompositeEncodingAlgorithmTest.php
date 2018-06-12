<?php

namespace Tests\App;

use PHPUnit\Framework\TestCase;

/**
 * Class CompositeEncodingAlgorithmTest
 */
class CompositeEncodingAlgorithmTest extends TestCase
{
    public function testComposedAlgorithmsAreCalled()
    {
        $algorithmA = $this->prophesize('\App\Algorithm\EncodingAlgorithm');
        $algorithmB = $this->prophesize('\App\Algorithm\EncodingAlgorithm');

        $algorithmA->encode("plain text")->willReturn("encoded text")->shouldBeCalledTimes(1);
        $algorithmB->encode("encoded text")->willReturn("text encoded twice")->shouldBeCalledTimes(1);

        $algorithm = new \App\Algorithm\CompositeEncodingAlgorithm();
        $algorithm->add($algorithmA->reveal());
        $algorithm->add($algorithmB->reveal());

        $this->assertSame("text encoded twice", $algorithm->encode("plain text"));
    }
}
