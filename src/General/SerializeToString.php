<?php

namespace Pageon\SlackWebhookMonolog\General;

use JsonSerializable;

/**
 * This will return the string representation when the class is encoded to json.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
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
