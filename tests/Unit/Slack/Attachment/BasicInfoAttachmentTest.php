<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack\Attachment;

use Monolog\Logger;
use Pageon\SlackWebhookMonolog\Slack\Attachment\BasicInfoAttachment;
use PHPUnit_Framework_TestCase;

class BasicInfoAttachmentTest extends PHPUnit_Framework_TestCase
{
    public function testIncludesContextIfRecordHasIt()
    {
        $record = [
            'message' => 'foo',
            'level' => Logger::ALERT,
            'level_name' => 'ALERT',
            'datetime' => new \DateTime(),
            'context' => ['foo' => 'bar'],
        ];

        $attachment = new BasicInfoAttachment($record);
        $data = $attachment->get();

        $this->assertArrayHasKey(2, $data['fields']);
        $context = $data['fields'][2]->jsonSerialize();
        $this->assertSame('Context', $context['title']);
        $this->assertSame(json_encode(['foo' => 'bar']), $context['value']);
    }

    public function testIncludesExtraIfRecordHasIt()
    {
        $record = [
            'message' => 'foo',
            'level' => Logger::ALERT,
            'level_name' => 'ALERT',
            'datetime' => new \DateTime(),
            'extra' => ['foo' => 'bar'],
        ];

        $attachment = new BasicInfoAttachment($record);
        $data = $attachment->get();

        $this->assertArrayHasKey(2, $data['fields']);
        $context = $data['fields'][2]->jsonSerialize();
        $this->assertSame('Extra', $context['title']);
        $this->assertSame(json_encode(['foo' => 'bar']), $context['value']);
    }
}
