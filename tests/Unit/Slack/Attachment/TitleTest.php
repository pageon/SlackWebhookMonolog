<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Title;
use PHPUnit_Framework_TestCase;

class TitleTest extends PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $title = 'bob';
        $this->assertEquals($title, (new Title($title))->getTitle());
        $this->assertEquals($title, (string) new Title($title));
    }

    public function testHasLink()
    {
        $this->assertTrue((new Title('bob', new Url('http://pageon.be')))->hasLink());
        $this->assertFalse((new Title('bob'))->hasLink());
    }

    public function testLink()
    {
        $link = new Url('http://pageon.be');
        $this->assertEquals($link, (new Title('bob', $link))->getLink());
    }
}
