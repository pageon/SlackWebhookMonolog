<?php

namespace Pageon\SlackMonolog\Tests;

use Pageon\SlackMonolog\Slack\EmojiIcon;
use Pageon\SlackMonolog\Slack\User;
use Pageon\SlackMonolog\Slack\Username;
use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackMonolog\Slack\Interfaces\UserInterface',
            new User(),
            "The class doesn't implement the UserInterface"
        );
    }

    /**
     * This will test if the check for the existence of a username works properly.
     */
    public function testUsername()
    {
        $userWithoutUsername = new User();
        $this->assertFalse(
            $userWithoutUsername->hasUsername(),
            'When there is no Username the function hasUsername should return false'
        );

        $username = new Username('Han Solo');
        $userWithUsername = new User($username);
        $this->assertTrue(
            $userWithUsername->hasUsername(),
            'When there is a Username the function hasUsername should return true'
        );

        $this->assertEquals(
            $username,
            $userWithUsername->getUsername(),
            'The returned username should be the same as the provided username'
        );
    }

    /**
     * This will test if the check for the existence of a icon works properly.
     */
    public function testIcon()
    {
        $userWithoutIcon = new User();
        $this->assertFalse(
            $userWithoutIcon->hasIcon(),
            'When there is no Icon the function hasIcon should return false'
        );

        $icon = new EmojiIcon(':angel:');
        $userWithIcon = new User(null, $icon);
        $this->assertTrue(
            $userWithIcon->hasIcon(),
            'When there is a Icon the function hasIcon should return true'
        );

        $this->assertEquals(
            $icon,
            $userWithIcon->getIcon(),
            'The returned icon should be the same as the provided icon'
        );
    }
}
