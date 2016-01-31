<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\UserInterface;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\WebhookInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class Config implements ConfigInterface
{
    /**
     * @var WebhookInterface the configuration for the webhook
     */
    private $webhook;

    /**
     * If not available the default config from slack will be used.
     *
     * @var UserInterface|null The configuration for the presentation of the webhook user.
     */
    private $customUser;

    /**
     * Config constructor.
     *
     * @param WebhookInterface $webhook
     * @param UserInterface|null $user
     */
    public function __construct(WebhookInterface $webhook, UserInterface $customUser = null)
    {
        $this->webhook = $webhook;
        $this->customUser = $customUser;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebhook()
    {
        return $this->webhook;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomUser()
    {
        return $this->customUser;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCustomUser()
    {
        return $this->customUser !== null;
    }
}
