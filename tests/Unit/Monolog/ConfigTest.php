<?php

namespace Pageon\SlackChannelMonolog\tests\Unit\Monolog;

use Monolog\Logger;
use Pageon\SlackWebhookMonolog\Monolog\Config;
use PHPUnit_Framework_TestCase;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Monolog\Interfaces\ConfigInterface',
            new Config(Logger::DEBUG),
            "The class doesn't implement the ConfigInterface"
        );
    }

    /**
     * Test if we have the correct level.
     */
    public function testLevel()
    {
        $config = new Config(Logger::DEBUG);
        $this->assertEquals(
            Logger::DEBUG,
            $config->getLevel(),
            sprintf('The level needs to be "%d"', Logger::DEBUG)
        );
    }

    /**
     * Test if we have the correct level.
     */
    public function testNonExistingLevel()
    {
        $this->setExpectedException(
            'Pageon\SlackWebhookMonolog\Monolog\Exceptions\InvalidLoggerLevelException',
            '',
            400
        );
        new Config('notExistingLevel');
    }

    /**
     * Test the bubble setting.
     */
    public function testBubble()
    {
        $this->assertTrue((new Config(Logger::DEBUG))->doesBubble(), 'The default bubble setting should be true');
        $this->assertTrue(
            (new Config(Logger::DEBUG, true))->doesBubble(),
            'The default bubble setting should match the one in the constructor'
        );
        $this->assertFalse(
            (new Config(Logger::DEBUG, false))->doesBubble(),
            'The default bubble setting should match the one in the constructor'
        );
    }
}
