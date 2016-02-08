<?php

namespace Pageon\SlackWebhookMonolog\Slack\Interfaces;

use JsonSerializable;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
interface ChannelInterface extends JsonSerializable
{
    /**
     * Returns the channel.
     *
     * @return string
     */
    public function getChannel();

    /**
     * The string representation of the Channel class should match the channel.
     *
     * @return string
     */
    public function __toString();
}
