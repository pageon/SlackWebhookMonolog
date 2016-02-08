<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use JsonSerializable;

/**
 * This will return the string representation when the class is encoded to json.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 */
abstract class SerializeToString implements JsonSerializable
{
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return (string) $this;
    }
}
