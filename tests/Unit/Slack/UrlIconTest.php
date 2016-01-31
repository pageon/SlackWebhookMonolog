<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use PHPUnit_Framework_TestCase;
use Pageon\SlackWebhookMonolog\Slack\UrlIcon;

class UrlIconTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Slack\Interfaces\IconInterface',
            new UrlIcon('http://placehold.it/512x512.png'),
            "The class doesn't implement the IconInterface"
        );
    }

    /**
     * Do we actually get the icon back we put into the class?
     */
    public function testGetIcon()
    {
        $url = 'http://placehold.it/512x512.png';
        $urlIcon = new UrlIcon($url);
        $this->assertEquals($url, $urlIcon->getIcon(), 'The icon url is not returned correctly');
    }

    /**
     * This will test the _toString implementation.
     */
    public function testToString()
    {
        $url = 'http://placehold.it/512x512.png';
        $urlIcon = new UrlIcon($url);
        $this->assertEquals($url, $urlIcon, 'When the Icon is cast to string it should return the url');
    }

    /**
     * Are only urls allowed for the icon?
     */
    public function testValidateUrl()
    {
        $this->setExpectedException('Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidUrlException');
        new UrlIcon('notAnUrl');
    }

    /**
     * This will test if the whitespace around the url is trimmed.
     */
    public function testWhiteSpaceAroundUrl()
    {
        $url = 'http://placehold.it/512x512.png';
        $this->assertEquals($url, new UrlIcon(' ' . $url), 'Whitespace before the url should be trimmed');
        $this->assertEquals($url, new UrlIcon($url . ' '), 'Whitespace after the url should be trimmed');
        $this->assertEquals(
            $url,
            new UrlIcon(' ' . $url . ' '),
            'Whitespace before and after the url should be trimmed'
        );
    }
}
