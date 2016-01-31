<?php

namespace Pageon\SlackWebhookMonolog\Tests;

use PHPUnit_Framework_TestCase;
use Pageon\SlackWebhookMonolog\Slack\EmojiIcon;

class EmojiIconTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Slack\Interfaces\IconInterface',
            new EmojiIcon(':kissing_closed_eyes:'),
            "The class doesn't implement the IconInterface"
        );
    }

    /**
     * Do we actually get the icon back we put into the class?
     */
    public function testGetIcon()
    {
        $emoji = ':kissing_closed_eyes+1:';
        $emojiIcon = new EmojiIcon($emoji);
        $this->assertEquals($emoji, $emojiIcon->getIcon(), 'The icon emoji is not returned correctly');
    }

    /**
     * This will test the _toString implementation.
     */
    public function testToString()
    {
        $emoji = ':kissing_closed_eyes+1:';
        $emojiIcon = new EmojiIcon($emoji);
        $this->assertEquals($emoji, $emojiIcon, 'When the Icon is cast to string it should return the url');
    }

    /**
     * Are only valid emojis allowed for the icon?
     * An amoji of slack always needs to start and end with : and can not contain spaces.
     */
    public function testValidateEmoji()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidEmojiException');
        new EmojiIcon('notAn Empji');
    }

    /**
     * This will test if the whitespace around the emoji is trimmed.
     */
    public function testWhiteSpaceAroundUrl()
    {
        $emoji = ':kissing_closed_eyes+1:';
        $this->assertEquals($emoji, new EmojiIcon(' ' . $emoji), 'Whitespace before the emoji should be trimmed');
        $this->assertEquals($emoji, new EmojiIcon($emoji . ' '), 'Whitespace after the emoji should be trimmed');
        $this->assertEquals(
            $emoji,
            new EmojiIcon(' ' . $emoji . ' '),
            'Whitespace before and after the emoji should be trimmed'
        );
    }
}
