<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack;

use Pageon\SlackWebhookMonolog\Monolog\Error;
use PHPUnit_Framework_TestCase;

class ErrorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Does the class implements the interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf(
            'Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface',
            new Error('test message', 1, __FILE__),
            "The class doesn't implement the ErrorInterface"
        );
    }

    public function testMessage()
    {
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals('test message', $error->getMessage());
    }

    public function testLineNumber()
    {
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals(1, $error->getLine());
    }

    public function testFile()
    {
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals(__FILE__, $error->getFile());
    }

    public function testTrace()
    {
        $testTrace = debug_backtrace();
        $error = new Error('test message', 1, __FILE__, $testTrace);

        $this->assertEquals($testTrace, $error->getTrace());
    }

    public function testTraceFallback()
    {
        $fallbackTrace = [
            [
                'line' => 1,
                'file' => __FILE__,
                'function' => 'unknown'
            ],
        ];
        $error = new Error('test message', $fallbackTrace[0]['line'], $fallbackTrace[0]['file']);

        $this->assertEquals($fallbackTrace, $error->getTrace());
    }

    public function testParameters()
    {
        $parameters = [
            '_POST' => [
                'test'
            ],
            '_GET' => [
                'test'
            ],
            '_COOKIE' => [
                'test'
            ],
            '_SESSION' => [
                'test'
            ],
        ];

        $error = new Error('test message', 1, __FILE__, null, $parameters);

        $this->assertEquals($parameters, $error->getParameters());
    }

    public function testParametersCookie()
    {
        $this->resetCookiePostGetAndSession();

        $_COOKIE['test_cookie'] = true;
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals(['_COOKIE' => ['test_cookie' => true]], $error->getParameters());
    }

    public function testParametersPost()
    {
        $this->resetCookiePostGetAndSession();

        $_POST['test_post'] = true;
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals(['_POST' => ['test_post' => true]], $error->getParameters());
    }

    public function testParametersGet()
    {
        $this->resetCookiePostGetAndSession();

        $_GET['test_GET'] = true;
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals(['_GET' => ['test_GET' => true]], $error->getParameters());
    }

    public function testParametersSession()
    {
        $this->resetCookiePostGetAndSession();

        $_SESSION['test_session'] = true;
        $error = new Error('test message', 1, __FILE__);
        $this->assertEquals(['_SESSION' => ['test_session' => true]], $error->getParameters());
    }

    private function resetCookiePostGetAndSession()
    {
        $_POST = $_GET = $_SESSION = $_COOKIE = null;
    }
}
