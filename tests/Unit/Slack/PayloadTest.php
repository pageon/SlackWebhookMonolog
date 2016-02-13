<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Monolog\Logger;
use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Monolog\Error;
use Pageon\SlackWebhookMonolog\Slack\Channel;
use Pageon\SlackWebhookMonolog\Slack\Config;
use Pageon\SlackWebhookMonolog\Slack\EmojiIcon;
use Pageon\SlackWebhookMonolog\Slack\Payload;
use Pageon\SlackWebhookMonolog\Slack\UrlIcon;
use Pageon\SlackWebhookMonolog\Slack\User;
use Pageon\SlackWebhookMonolog\Slack\Username;
use Pageon\SlackWebhookMonolog\Slack\Webhook;
use PHPUnit_Framework_TestCase;

class PayloadTest extends PHPUnit_Framework_TestCase
{
    /**
     * Get a dummy record.
     *
     * @param bool $addErrorContext true if an there needs to be an error in the context.
     *
     * @return array
     */
    private function getRecord($addErrorContext = false, $level = Logger::ERROR)
    {
        $record = json_decode(
            '{"message":"Test success","context":{},"level":' . $level . ',"level_name":"ERROR","channel":"pageon","datetime":{"date":"2016-02-08 01:01:36.719769","timezone_type":3,"timezone":"Europe\/Brussels"},"extra":[],"formatted":"[2016-02-08 01:01:36] pageon.ERROR: Test success {\"error\":\"[object] (Pageon\\\\SlackWebhookMonolog\\\\Monolog\\\\Error: {})\"} []\n"}',
            true
        );

        $record['datetime'] = new \DateTime();

        if (!$addErrorContext) {
            return $record;
        }

        $record['context']['error'] = new Error('Test with context', 2, __FILE__, debug_backtrace());

        return $record;
    }

    /**
     * @return Webhook
     */
    private function getWebhook()
    {
        return new Webhook(
            new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX'),
            new Channel('#general')
        );
    }

    /**
     * @return User
     */
    private function getUserWithUsername()
    {
        return new User(new Username('ErrorBot'));
    }

    /**
     * @return User
     */
    private function getEmojiIconUser()
    {
        return new User(null, new EmojiIcon(':alien:'));
    }

    /**
     * @return User
     */
    private function getUrlIconUser()
    {
        return new User(null, new UrlIcon('https://slack.com/img/icons/app-57.png'));
    }

    public function testPayloadWithoutErrorContext()
    {
        $payload = new Payload($this->getRecord());

        $this->assertContains('"fallback":"Test success"', json_encode($payload));
    }

    public function testPayloadWithErrorContext()
    {
        $payload = new Payload($this->getRecord(true));

        $this->assertContains('"fallback":"Test with context"', (string) $payload);
    }

    public function testCustomChannel()
    {
        $webhookWithoutChannel = new Webhook(
            new Url('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX')
        );
        $payload = json_encode(new Payload($this->getRecord(true), new Config($webhookWithoutChannel)));
        $this->assertNotContains('"channel"', $payload);

        $payload = json_encode(new Payload($this->getRecord(true), new Config($this->getWebhook())));
        $this->assertContains('"channel":"#general"', $payload);
    }

    public function testCustomUsername()
    {
        $payload = json_encode(
            new Payload($this->getRecord(true), new Config($this->getWebhook(), $this->getUserWithUsername()))
        );

        $this->assertContains('"username":"ErrorBot"', $payload);
    }

    public function testCustomEmojiIcon()
    {
        $payload = json_encode(
            new Payload($this->getRecord(true), new Config($this->getWebhook(), $this->getEmojiIconUser()))
        );

        $this->assertContains('"icon_emoji":":alien:"', $payload);
    }

    public function testCustomUrlIcon()
    {
        $payload = json_encode(
            new Payload($this->getRecord(true), new Config($this->getWebhook(), $this->getUrlIconUser()))
        );

        $this->assertContains('"icon_url":"https:\/\/slack.com\/img\/icons\/app-57.png"', $payload);
    }

    public function testAttachmentColours()
    {
        $this->assertContains('"color":"danger"', json_encode(new Payload($this->getRecord(true))));
        $this->assertContains('"color":"warning"', json_encode(new Payload($this->getRecord(true, Logger::WARNING))));
        $this->assertContains('"color":"good"', json_encode(new Payload($this->getRecord(true, Logger::INFO))));
        $this->assertContains('"color":"#e3e4e6"', json_encode(new Payload($this->getRecord(true, Logger::DEBUG))));
    }
}
