<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Pageon\SlackWebhookMonolog\Slack\Channel;
use PHPUnit_Framework_TestCase;

class ChannelTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Slack\Interfaces\ChannelInterface',
            new Channel('#monolog'),
            "The class doesn't implement the ChannelInterface"
        );
    }

    /**
     * Do we actually get the channel back we put into the class?
     */
    public function testGetIcon()
    {
        $channelName = '#monolog';
        $channel = new Channel($channelName);
        $this->assertEquals($channelName, $channel->getChannel(), 'The channel name is not returned correctly');
    }

    /**
     * This will test the _toString implementation.
     */
    public function testToString()
    {
        $channelName = '#monolog';
        $channel = new Channel($channelName);
        $this->assertEquals(
            $channelName,
            $channel,
            'When the Channel is cast to string it should return the channel name'
        );
    }

    /**
     * This will test if the whitespace around the channel name is trimmed.
     */
    public function testWhiteSpaceAroundChannelName()
    {
        $channelName = '#monolog';
        $this->assertEquals(
            $channelName,
            new Channel(' ' . $channelName),
            'Whitespace before the channel name should be trimmed'
        );
        $this->assertEquals(
            $channelName,
            new Channel($channelName . ' '),
            'Whitespace after the channel name should be trimmed'
        );
        $this->assertEquals(
            $channelName,
            new Channel(' ' . $channelName . ' '),
            'Whitespace before and after the channel name should be trimmed'
        );
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an account.
     */
    public function testChannelNameisNotAChannelOrAnAccount()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('han solo');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an account.
     */
    public function testAccountTypeChannelNameCannotContainSpaces()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('@dzaj azdadz');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an account.
     */
    public function testAccountTypeChannelNameCannotContainStrangeCharacters()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('@dzaj~azdadz');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an account.
     */
    public function testAccountTypeChannelNameCannotBeEmpty()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('@');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an account.
     */
    public function testAccountTypeChannelNameCannotBeLongerThan21Chars()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('@azertyuiopqsdfghjklmwx');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an account.
     */
    public function testAccountTypeChannelNameCanBe21Chars()
    {
        $username = '@azertyuiopqsdfghj1_--';
        $this->assertEquals($username, new Channel($username));
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an channel.
     */
    public function testChannelTypeChannelNameCannotContainSpaces()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('#dzaj azdadz');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an channel.
     */
    public function testChannelTypeChannelNameCannotContainStrangeCharacters()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('#dzaj~azdadz');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an channel.
     */
    public function testChannelTypeChannelNameCannotBeEmpty()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('#');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an channel.
     */
    public function testChannelTypeChannelNameCannotBeCompletelyEmpty()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an channel.
     */
    public function testChannelTypeChannelNameCannotBeLongerThan21Chars()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException', '', 400);
        new Channel('#azertyuiopqsdfghjklmwx');
    }

    /**
     * This will test if there is an error when the channel name that is passed is not a channel or an channel.
     */
    public function testChannelTypeChannelNameCannotBe21Chars()
    {
        $username = '#azertyuiopqsdfghj1_-_';
        $this->assertEquals($username, new Channel($username));
    }

    /**
     * The return of the jsonSerialize function should match the toString implementation.
     */
    public function testJsonSerialize()
    {
        $channel = new Channel('@bob');

        $this->assertEquals((string) $channel, $channel->jsonSerialize());
    }
}
