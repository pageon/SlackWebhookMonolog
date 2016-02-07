<?php

namespace Pageon\SlackWebhookMonolog\Monolog\Interfaces;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
interface ConfigInterface
{
    /**
     * The minimum logging level at which this handler will be triggered.
     *
     * @return int
     */
    public function getLevel();

    /**
     * Whether the messages that are handled can bubble up the stack or not.
     *
     * @return bool
     */
    public function doesBubble();
}
