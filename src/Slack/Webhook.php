<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidUrlException;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ChannelInterface;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\WebhookInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class Webhook implements WebhookInterface
{
    /**
     * The url of the webhook. This is provided by slack after creating a webhook.
     *
     * @var string
     */
    private $url;

    /**
     * A custom channel to override the default set in slack.
     *
     * @var ChannelInterface|null
     */
    private $customChannel = null;

    /**
     * @param string $url The webhook url provided by slack.
     * @param ChannelInterface|null $customChannel if no channel is provided the default will be used from the config in slack.
     */
    public function __construct($url, ChannelInterface $customChannel = null)
    {
        $this->setUrl($url);
        $this->customChannel = $customChannel;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * This wil set the url if it is valid.
     *
     * @param string $url
     *
     * @throws InvalidUrlException When it is not a valid webhook url of slack
     *
     * @return self
     */
    private function setUrl($url)
    {
        $url = trim($url);

        $urlValidationRegex = '_https:\/\/hooks.slack.com\/services\/[\w\/]+$_iuS';
        if (!preg_match($urlValidationRegex, $url)) {
            throw new InvalidUrlException(
                sprintf(
                    'The url: "%s" is not a valid url.
                     Slack webhook urls should always start with "https://hooks.slack.com/services/"',
                    $url
                ),
                400
            );
        }
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomChannel()
    {
        return $this->customChannel;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCustomChannel()
    {
        return $this->customChannel !== null;
    }
}
