<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack\Attachment;

use Pageon\SlackWebhookMonolog\Slack\Attachment\Colour;
use PHPUnit_Framework_TestCase;

class ColourTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultColours()
    {
        $this->assertEquals(Colour::COLOUR_GOOD, new Colour(Colour::COLOUR_GOOD));
        $this->assertEquals(Colour::COLOUR_WARNING, new Colour(Colour::COLOUR_WARNING));
        $this->assertEquals(Colour::COLOUR_DANGER, new Colour(Colour::COLOUR_DANGER));
    }

    public function testJsonEncoding()
    {
        $this->assertEquals('"' . Colour::COLOUR_GOOD . '"', json_encode(new Colour(Colour::COLOUR_GOOD)));
    }

    public function testGetter()
    {
        $this->assertEquals(Colour::COLOUR_DANGER, (new Colour(Colour::COLOUR_DANGER))->getColour());
    }

    public function testHexColours()
    {
        $hexColours = [
            '#FFFFFF',
            '#000000',
            '#C0C0C0',
            '#808080',
            '#FF0000',
            '#F0A804',
            '#FFFF00',
            '#008000',
            '#800080',
            '#09F',
            '#ADE',
            '#982',
            '#A67',
        ];

        array_walk(
            $hexColours,
            function ($hexColour) {
                $this->assertEquals($hexColour, new Colour($hexColour));
            }
        );
    }

    public function testInvalidColour()
    {
        $this->setExpectedException('\Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidColourException');
        new Colour('green');
    }
}
