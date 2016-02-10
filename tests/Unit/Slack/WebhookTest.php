<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Channel;
use PHPUnit_Framework_TestCase;
use Pageon\SlackWebhookMonolog\Slack\Webhook;

class WebhookTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Slack\Interfaces\WebhookInterface',
            new Webhook(new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX')),
            "The class doesn't implement the WebhookInterface"
        );
    }

    /**
     * Do we actually get the icon back we put into the class?
     */
    public function testGetUrl()
    {
        $url = new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX');
        $webhook = new Webhook($url);
        $this->assertEquals($url, $webhook->getUrl(), 'The webhook url is not returned correctly');
    }

    /**
     * This will test if the check for the existence of a username works properly.
     */
    public function testCustomChannel()
    {
        $webhookWithoutCustomChannel = new Webhook(
            new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX')
        );
        $this->assertFalse(
            $webhookWithoutCustomChannel->hasCustomChannel(),
            'When there is no custom channel the function hasCustomChannel should return false'
        );

        $channel = new Channel('@pageon');
        $webhookWithCustomChannel = new Webhook(
            new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX'),
            $channel
        );
        $this->assertTrue(
            $webhookWithCustomChannel->hasCustomChannel(),
            'When there is a CustomChannel the function hasCustomChannel should return true'
        );

        $this->assertEquals(
            $channel,
            $webhookWithCustomChannel->getCustomChannel(),
            'The returned channel should be the same as the provided channel'
        );
    }

    /**
     * This will test the _toString implementation.
     */
    public function testToString()
    {
        $url = new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX');
        $webhook = new Webhook($url);
        $this->assertEquals((string) $url, $webhook, 'When the Webhook is cast to string it should return the webhook url');
    }

    /**
     * Are only urls allowed for the webhook?
     */
    public function testValidateUrl()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\General\Exceptions\InvalidUrlException');
        new Webhook(new Url('http://google.com'));
    }

    /**
     * This will test if the whitespace around the webhook url is trimmed.
     */
    public function testWhiteSpaceAroundUrl()
    {
        $url = 'https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX';
        $this->assertEquals($url, new Webhook(new Url(' ' . $url)), 'Whitespace before the url should be trimmed');
        $this->assertEquals($url, new Webhook(new Url($url . ' ')), 'Whitespace after the url should be trimmed');
        $this->assertEquals(
            $url,
            new Webhook(new Url(' ' . $url . ' ')),
            'Whitespace before and after the url should be trimmed'
        );
    }
}
