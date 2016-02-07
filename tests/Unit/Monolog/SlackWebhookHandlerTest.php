<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Monolog;

use Monolog\Logger;
use Pageon\SlackChannelMonolog\Tests\Unit\Monolog\Mocks\CurlUtil;
use Pageon\SlackWebhookMonolog\Monolog\Config as MonologConfig;
use Pageon\SlackWebhookMonolog\Monolog\SlackWebhookHandler;
use Pageon\SlackWebhookMonolog\Slack\Config as SlackConfig;
use Pageon\SlackWebhookMonolog\Slack\Webhook;
use PHPUnit_Framework_TestCase;

class SlackWebhookHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Monolog\Handler\AbstractProcessingHandler',
            new SlackWebhookHandler(
                new SlackConfig(
                    new Webhook('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX')
                ),
                new MonologConfig(Logger::DEBUG),
                new CurlUtil()
            ),
            "The class doesn't implement the AbstractProcessingHandler interface of Monolog"
        );
    }

    public function testWrite()
    {
        $webhookUrl = 'https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX';
        $handler = new SlackWebhookHandler(
            new SlackConfig(
                new Webhook($webhookUrl)
            ),
            new MonologConfig(Logger::DEBUG),
            new CurlUtil()
        );

        $curlSession = $handler->write(['message' => 'test']);
        $this->assertInternalType('resource', $curlSession);

        $curlSessionInfo = curl_getinfo($curlSession);

        $this->assertEquals($webhookUrl, $curlSessionInfo['url']);
    }
}
