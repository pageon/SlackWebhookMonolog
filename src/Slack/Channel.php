<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ChannelInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class Channel extends SerializeToString implements ChannelInterface
{
    private $name;

    /**
     * Channel constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    private function setName($name)
    {
        // names should be lowercase so we just enforce this without further validation
        $name = trim(mb_strtolower($name, 'UTF8'));

        if (!preg_match('_^[#@][\w-]{1,21}$_', $name)) {
            throw new InvalidChannelException(
                'Channel names must be all lowercase.
                 The name should start with "#" for a channel or "@" for an account
                 They cannot be longer than 21 characters and can only contain letters, numbers, hyphens, and underscores.',
                400
            );
        }

        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getChannel();
    }
}
