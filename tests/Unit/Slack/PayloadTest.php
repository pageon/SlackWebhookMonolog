<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Pageon\SlackWebhookMonolog\Monolog\Error;
use Pageon\SlackWebhookMonolog\Slack\Payload;
use PHPUnit_Framework_TestCase;

class PayloadTest extends PHPUnit_Framework_TestCase
{
    /**
     * Get a dummy record.
     *
     * @param bool $addErrorContext true if an there needs to be an error in the context.
     * @return array
     */
    private function getRecord($addErrorContext = false)
    {
        $record = json_decode(
            '{"message":"Test success","context":{},"level":400,"level_name":"ERROR","channel":"pageon","datetime":{"date":"2016-02-08 01:01:36.719769","timezone_type":3,"timezone":"Europe\/Brussels"},"extra":[],"formatted":"[2016-02-08 01:01:36] pageon.ERROR: Test success {\"error\":\"[object] (Pageon\\\\SlackWebhookMonolog\\\\Monolog\\\\Error: {})\"} []\n"}',
            true
        );

        if (!$addErrorContext) {
            return $record;
        }

        $record['context']['error'] = new Error('Test with context', 2, __FILE__, debug_backtrace());

        return $record;
    }

    public function testPayloadWithoutErrorContext()
    {
        $payload = new Payload($this->getRecord());

        $this->assertEquals('{"text":"*ERROR:* Test success"}', json_encode($payload));
    }

    public function testPayloadWithErrorContext()
    {
        $payload = new Payload($this->getRecord(true));

        $this->assertEquals('{"text":"*ERROR:* Test with context"}', json_encode($payload));
    }
}
