<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\IconInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class UrlIcon extends Url implements IconInterface
{
    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return $this->getUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'url';
    }
}
