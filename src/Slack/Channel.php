<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidChannelException;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ChannelInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class Channel implements ChannelInterface
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
        $name = trim($name);

        switch ($name[0]) {
            case '#':
                // names should be lowercase so we just enforce this without further validation
                $name = mb_strtolower($name, 'UTF8');

                // check if the username matches the requirements from slack
                $validationRegex = '_^#[\w-]{1,21}$_';
                if (!preg_match($validationRegex, $name)) {
                    throw new InvalidChannelException(
                        'Channel names must be all lowercase.
                         They cannot be longer than 21 characters and can only contain letters, numbers, hyphens, and underscores.',
                        400
                    );
                }

                $this->name = $name;

                return;
            case '@':
                // names should be lowercase so we just enforce this without further validation
                $name = mb_strtolower($name, 'UTF8');

                // check if the username matches the requirements from slack
                $validationRegex = '_^@[\w-.]{1,21}$_';
                if (!preg_match($validationRegex, $name)) {
                    throw new InvalidChannelException(
                        'Usernames must be all lowercase.
                         They cannot be longer than 21 characters and can only contain letters, numbers, periods, hyphens, and underscores.',
                        400
                    );
                }

                $this->name = $name;

                return;
            default:
                throw new InvalidChannelException(
                    'The name should start with "#" for a channel or "@" for an account.
                    The name that was provided did not start with either of those.',
                    400
                );
        }
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
