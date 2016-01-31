<?php

namespace Pageon\SlackWebhookMonolog\Slack\Interfaces;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
interface ConfigInterface
{
    /**
     * @return WebhookInterface
     */
    public function getWebhook();

    /**
     * If there is a user this will override the default configuration from Slack.
     *
     * @return UserInterface|null
     */
    public function getCustomUser();

    /**
     * This will return true if there is a user.
     *
     * @return bool
     */
    public function hasCustomUser();
}
