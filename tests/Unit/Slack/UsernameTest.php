<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use PHPUnit_Framework_TestCase;
use Pageon\SlackWebhookMonolog\Slack\Username;

class UsernameTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Slack\Interfaces\UsernameInterface',
            new Username('Pageon'),
            "The class doesn't implement the UsernameInterface"
        );
    }

    /**
     * Do we actually get the username back we put into the class?
     */
    public function testGetUsername()
    {
        $usernameString = 'Pageon';
        $username = new Username($usernameString);
        $this->assertEquals($usernameString, $username->getUsername(), 'The username is not returned correctly');
    }

    /**
     * This will test the _toString implementation.
     */
    public function testToString()
    {
        $usernameString = 'Pageon';
        $username = new Username($usernameString);
        $this->assertEquals(
            $usernameString,
            $username,
            'When the Username is cast to string it should return the username'
        );
    }

    /**
     * This will test if the whitespace around the username is trimmed.
     */
    public function testWhiteSpaceAroundUsername()
    {
        $usernameString = 'Pageon';
        $this->assertEquals(
            $usernameString,
            new Username($usernameString . ' '),
            'Whitespace after the username should be trimmed'
        );
        $this->assertEquals(
            $usernameString,
            new Username($usernameString . ' '),
            'Whitespace after the username should be trimmed'
        );
        $this->assertEquals(
            $usernameString,
            new Username(' ' . $usernameString . ' '),
            'Whitespace before and after the username should be trimmed'
        );
    }

    /**
     * The return of the jsonSerialize function should match the toString implementation.
     */
    public function testJsonSerialize()
    {
        $username = new Username('carakas');

        $this->assertEquals((string) $username, $username->jsonSerialize());
    }
}
