<?php

namespace Pageon\SlackWebhookMonolog\Slack\Interfaces;

use Pageon\SlackWebhookMonolog\Slack\Channel;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
interface WebhookInterface
{
    /**
     * The url provided by slack when creating a webhook.
     *
     * @return string
     */
    public function getUrl();

    /**
     * A custom channel that will override the default set in the config on slack.
     *
     * @return ChannelInterface
     */
    public function getCustomChannel();

    /**
     * This will return true if there is a custom channel that will override the default set in the config on slack.
     *
     * @return bool
     */
    public function hasCustomChannel();

    /**
     * The to string representation of the webhook should return the url of the webhook.
     *
     * @return string
     */
    public function __toString();
}
