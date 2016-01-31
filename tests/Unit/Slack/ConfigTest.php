<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Pageon\SlackWebhookMonolog\Slack\Config;
use Pageon\SlackWebhookMonolog\Slack\User;
use Pageon\SlackWebhookMonolog\Slack\Username;
use PHPUnit_Framework_TestCase;
use Pageon\SlackWebhookMonolog\Slack\Webhook;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface',
            new Config(new Webhook('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX')),
            "The class doesn't implement the ConfigInterface"
        );
    }

    /**
     * This will test if we actually get a webhook back.
     */
    public function testWebhook()
    {
        $webhook = new Webhook('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX');
        $config = new Config($webhook);
        $this->assertEquals($webhook, $config->getWebhook());
    }

    public function testCustomUser()
    {
        $webhook = new Webhook('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXX');
        $configWithoutCustomUser = new Config($webhook);
        $this->assertFalse(
            $configWithoutCustomUser->hasCustomUser(),
            'When there is no custom user the function hasCustomUser should return false'
        );

        $user = new User(new Username('@pageon'));
        $configWithCustomUser = new Config(
            $webhook,
            $user
        );
        $this->assertTrue(
            $configWithCustomUser->hasCustomUser(),
            'When there is a CustomUser the function hasCustomUser should return true'
        );

        $this->assertEquals(
            $user,
            $configWithCustomUser->getCustomUser(),
            'The returned user should be the same as the provided user'
        );
    }
}
