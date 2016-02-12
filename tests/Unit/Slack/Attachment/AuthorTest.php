<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Author;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Title;
use PHPUnit_Framework_TestCase;

class AuthorTest extends PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $name = 'Mark Twain';
        $author = new Author($name);

        $this->assertEquals($name, $author->getName());
        $this->assertEquals($name, (string) $author);
        $this->assertEquals('"' . $name . '"', json_encode($author));
    }

    public function testLink()
    {
        $authorNoLink = new Author('J.R.R. Tolkien');
        $this->assertFalse($authorNoLink->hasLink());

        $link = new Url('https://en.wikipedia.org/wiki/George_Orwell');
        $authorLink = new Author('George Orwell', $link);
        $this->assertTrue($authorLink->hasLink());
        $this->assertEquals($link, $authorLink->getLink());
    }

    public function testIcon()
    {
        $authorNoIcon = new Author('J.R.R. Tolkien');
        $this->assertFalse($authorNoIcon->hasIcon());

        $icon = new Url('https://upload.wikimedia.org/wikipedia/commons/7/7e/George_Orwell_press_photo.jpg');
        $authorIcon = new Author('George Orwell', null, $icon);
        $this->assertTrue($authorIcon->hasIcon());
        $this->assertEquals($icon, $authorIcon->getIcon());
    }
}
