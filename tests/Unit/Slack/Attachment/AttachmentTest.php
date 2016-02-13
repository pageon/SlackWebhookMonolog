<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Attachment;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Author;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Colour;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Field;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Title;
use PHPUnit_Framework_TestCase;

class AttachmentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return Attachment
     */
    private function getAttachment()
    {
        return new Attachment('test attachment');
    }

    public function testFallback()
    {
        $fallback = 'I\'ll notify you';
        $attachment = new Attachment($fallback);
        $this->assertEquals($fallback, $attachment->getFallback());

        $this->assertTrue(isset($attachment->get()['fallback']));
        $this->assertEquals($fallback, $attachment->get()['fallback']);

        $this->assertContains('"fallback":"' . $fallback . '"', json_encode($attachment));

        $this->setExpectedException('InvalidArgumentException', 'The fallback is required');
        new Attachment('');
    }

    public function testText()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getText());
        $this->assertFalse($attachment->hasText());
        $this->assertFalse(isset($attachment->get()['text']));

        $text = 'This is a dummy text';
        $attachment->setText($text);
        $this->assertTrue($attachment->hasText());
        $this->assertEquals($text, $attachment->getText());

        $this->assertTrue(isset($attachment->get()['text']));
        $this->assertEquals($text, $attachment->get()['text']);

        $this->assertContains('"text":"' . $text . '"', json_encode($attachment));
    }

    public function testPretext()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getPretext());
        $this->assertFalse($attachment->hasPretext());
        $this->assertFalse(isset($attachment->get()['pretext']));

        $pretext = 'This is a dummy pretext';
        $attachment->setPretext($pretext);
        $this->assertTrue($attachment->hasPretext());
        $this->assertEquals($pretext, $attachment->getPretext());

        $this->assertTrue(isset($attachment->get()['pretext']));
        $this->assertEquals($pretext, $attachment->get()['pretext']);

        $this->assertContains('"pretext":"' . $pretext . '"', json_encode($attachment));
    }

    public function testColour()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getColour());
        $this->assertFalse($attachment->hasColour());
        $this->assertFalse(isset($attachment->get()['color']));

        $colour = new Colour(Colour::COLOUR_GOOD);
        $attachment->setColour($colour);
        $this->assertTrue($attachment->hasColour());
        $this->assertEquals($colour, $attachment->getColour());

        $this->assertTrue(isset($attachment->get()['color']));
        $this->assertEquals($colour, $attachment->get()['color']);

        $this->assertContains('"color":"' . $colour . '"', json_encode($attachment));
    }

    public function testImage()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getImage());
        $this->assertFalse($attachment->hasImage());
        $this->assertFalse(isset($attachment->get()['image_url']));

        $image = new Url('http://pageon.be/logo.png');
        $attachment->setImage($image);
        $this->assertTrue($attachment->hasImage());
        $this->assertEquals($image, $attachment->getImage());

        $this->assertTrue(isset($attachment->get()['image_url']));
        $this->assertEquals($image, $attachment->get()['image_url']);

        $this->assertContains('"image_url":' . json_encode($image), json_encode($attachment));
    }

    public function testThumbnail()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getThumbnail());
        $this->assertFalse($attachment->hasThumbnail());
        $this->assertFalse(isset($attachment->get()['thumb_url']));

        $thumbnail = new Url('http://pageon.be/logo.png');
        $attachment->setThumbnail($thumbnail);
        $this->assertTrue($attachment->hasThumbnail());
        $this->assertEquals($thumbnail, $attachment->getThumbnail());

        $this->assertTrue(isset($attachment->get()['thumb_url']));
        $this->assertEquals($thumbnail, $attachment->get()['thumb_url']);

        $this->assertContains('"thumb_url":' . json_encode($thumbnail), json_encode($attachment));
    }

    public function testMarkdownSettings()
    {
        $attachment = $this->getAttachment();

        $this->assertFalse(isset($attachment->get()['mrkdwn_in']));
        $this->assertNotContains('mrkdwn_in', json_encode($attachment));

        $attachment->enableMarkdownForFieldValues();
        $this->assertTrue(isset($attachment->get()['mrkdwn_in']));
        $this->assertTrue(in_array('fields', $attachment->get()['mrkdwn_in']));
        $this->assertContains('mrkdwn_in', json_encode($attachment));
        $this->assertContains('"fields"', json_encode($attachment));

        $this->assertNotContains('text', json_encode($attachment));
        $attachment->enableMarkdownForText();
        $this->assertContains('"text"', json_encode($attachment));

        $this->assertNotContains('pretext', json_encode($attachment));
        $attachment->enableMarkdownForPretext();
        $this->assertContains('"pretext"', json_encode($attachment));
    }

    public function testAuthor()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getAuthor());
        $this->assertFalse($attachment->hasAuthor());
        $this->assertFalse(isset($attachment->get()['author_url']));

        $baseAuthor = new Author('jelmer');
        $attachment->setAuthor($baseAuthor);
        $this->assertTrue($attachment->hasAuthor());
        $this->assertEquals($baseAuthor, $attachment->getAuthor());

        $this->assertTrue(isset($attachment->get()['author_name']));
        $this->assertEquals($baseAuthor, $attachment->get()['author_name']);

        $this->assertContains('"author_name":' . json_encode($baseAuthor), json_encode($attachment));

        $icon = new Url('http://pageon.be/logo.png');
        $link = new Url('http://pageon.be');
        $fullAuthor = new Author('jelmer', $link, $icon);
        $attachment->setAuthor($fullAuthor);

        $this->assertTrue(isset($attachment->get()['author_icon']));
        $this->assertEquals($icon, $attachment->get()['author_icon']);
        $this->assertContains('"author_icon":' . json_encode($icon), json_encode($attachment));

        $this->assertTrue(isset($attachment->get()['author_link']));
        $this->assertEquals($link, $attachment->get()['author_link']);
        $this->assertContains('"author_link":' . json_encode($link), json_encode($attachment));
    }

    public function testTitle()
    {
        $attachment = $this->getAttachment();

        $this->assertNull($attachment->getTitle());
        $this->assertFalse($attachment->hasTitle());
        $this->assertFalse(isset($attachment->get()['title_url']));

        $baseTitle = new Title('jelmer wrote this');
        $attachment->setTitle($baseTitle);
        $this->assertTrue($attachment->hasTitle());
        $this->assertEquals($baseTitle, $attachment->getTitle());

        $this->assertTrue(isset($attachment->get()['title']));
        $this->assertEquals($baseTitle, $attachment->get()['title']);

        $this->assertContains('"title":' . json_encode($baseTitle), json_encode($attachment));

        $link = new Url('http://pageon.be');
        $fullTitle = new Title('jelmer', $link);
        $attachment->setTitle($fullTitle);

        $this->assertTrue(isset($attachment->get()['title_link']));
        $this->assertEquals($link, $attachment->get()['title_link']);
        $this->assertContains('"title_link":' . json_encode($link), json_encode($attachment));
    }

    public function testField()
    {
        $attachment = $this->getAttachment();

        $this->assertEmpty($attachment->getFields());
        $this->assertFalse($attachment->hasFields());
        $this->assertFalse(isset($attachment->get()['fields']));

        $field = new Field('title', 'Jelmer wrote it');
        $attachment->addField($field);
        $this->assertTrue($attachment->hasFields());
        $this->assertCount(1, $attachment->getFields());
        $attachment->addField($field);
        $this->assertCount(2, $attachment->getFields());

        $attachmentArray = $attachment->get();
        $this->assertTrue(isset($attachmentArray['fields']));
        $this->assertEquals($field, $attachmentArray['fields'][0]);

        $this->assertContains('"fields":', json_encode($attachment));
        $this->assertContains(json_encode($field), json_encode($attachment));

        $attachment->addFields([$field, $field]);
        $this->assertCount(4, $attachment->getFields());
    }
}
