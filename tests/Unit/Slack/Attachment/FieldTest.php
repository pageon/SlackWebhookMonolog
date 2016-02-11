<?php

namespace Pageon\SlackChannelMonolog\Tests\Unit\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Field;
use Pageon\SlackWebhookMonolog\Slack\Attachment\Title;
use PHPUnit_Framework_TestCase;

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function testField()
    {
        $this->assertEquals(
            '{"title":"pilot","value":"Han Solo","short":false}',
            json_encode(new Field('pilot', 'Han Solo'))
        );
        $this->assertEquals(
            '{"title":"pilot","value":"Han Solo","short":false}',
            json_encode(new Field('pilot', 'Han Solo', false))
        );
        $this->assertEquals(
            '{"title":"pilot","value":"Han Solo","short":true}',
            json_encode(new Field('pilot', 'Han Solo', true))
        );
    }
}
