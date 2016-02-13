<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Config;
use Pageon\SlackWebhookMonolog\Slack\StringFormat;
use Pageon\SlackWebhookMonolog\Slack\User;
use Pageon\SlackWebhookMonolog\Slack\Username;
use PHPUnit_Framework_TestCase;
use Pageon\SlackWebhookMonolog\Slack\Webhook;

class StringFormatTest extends PHPUnit_Framework_TestCase
{
    public function testEscape()
    {
        $stringFormat = new StringFormat();
        $this->assertEquals('bob &amp; co', $stringFormat->escape('bob & co'));
        $this->assertEquals('knowledge &gt; power', $stringFormat->escape('knowledge > power'));
        $this->assertEquals('&lt;--', $stringFormat->escape('<--'));
    }

    public function testEmphasis()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals('*emphasised text*', $stringFormat->emphasis('emphasised text'));
    }

    public function testItalicize()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals('_italicized text_', $stringFormat->italicize('italicized text'));
    }

    public function testStrikethrough()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals('~strikethrough text~', $stringFormat->strikethrough('strikethrough text'));
    }

    public function testArrayToNumberedList()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals(
            "1. First item\n2. Second item\n3. Third item\n",
            $stringFormat->arrayToNumberedList(['First item', 'Second item', 'Third item'])
        );
    }

    public function testArrayToBulletList()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals(
            "• First item\n• Second item\n• Third item\n",
            $stringFormat->arrayToBulletList(['First item', 'Second item', 'Third item'])
        );

        $this->assertEquals(
            "§ First item\n§ Second item\n§ Third item\n",
            $stringFormat->arrayToBulletList(['First item', 'Second item', 'Third item'], '§')
        );
    }

    public function testPre()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals('```lorem ipsum bla bla bla```', $stringFormat->pre('lorem ipsum bla bla bla'));
    }

    public function testCode()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals('`$this->execute()`', $stringFormat->code('$this->execute()'));
    }

    public function testIndent()
    {
        $stringFormat = new StringFormat();

        $this->assertEquals('>I am indented', $stringFormat->indent('I am indented'));
        $this->assertEquals(
            ">I am indented\n>And the next line too",
            $stringFormat->indent("I am indented\nAnd the next line too")
        );
    }
}
