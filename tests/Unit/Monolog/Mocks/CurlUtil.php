<?php

namespace Pageon\SlackChannelMonolog\tests\Unit\Monolog\Mocks;

use Monolog\Handler\Curl\Util;

/**
 * Class CurlUtil
 *
 * @author Jelmer Prins <jelmer@$pageon.be>
 */
class CurlUtil extends Util
{
    /**
     * @param resource $ch
     * @param int $retries
     * @param bool $closeAfterDone
     *
     * @return resource
     */
    public static function execute($ch, $retries = 5, $closeAfterDone = true)
    {
        // do nothing here since we don't want to send a http request in our tests.
        return $ch;
    }
}
