<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Monolog;

require_once 'Mocks/CurlUtil.php';

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
     * Get a dummy record.
     */
    private function getRecord()
    {
        return json_decode(
            '{"message":"Test success","context":{},"level":400,"level_name":"ERROR","channel":"pageon","datetime":{"date":"2016-02-08 01:01:36.719769","timezone_type":3,"timezone":"Europe\/Brussels"},"extra":[],"formatted":"[2016-02-08 01:01:36] pageon.ERROR: Test success {\"error\":\"[object] (Pageon\\\\SlackWebhookMonolog\\\\Monolog\\\\Error: {})\"} []\n"}',
            true
        );
    }

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

        $curlSession = $handler->write($this->getRecord());
        $this->assertInternalType('resource', $curlSession);

        $curlSessionInfo = curl_getinfo($curlSession);

        $this->assertEquals($webhookUrl, $curlSessionInfo['url']);
    }
}
