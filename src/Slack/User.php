<?php

namespace Pageon\SlackMonolog\Slack;

use Pageon\SlackMonolog\Slack\Interfaces\IconInterface;
use Pageon\SlackMonolog\Slack\Interfaces\UserInterface;
use Pageon\SlackMonolog\Slack\Interfaces\UsernameInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class User implements UserInterface
{
    /**
     * @var UsernameInterface|null
     */
    private $username = null;

    /**
     * @var IconInterface|null
     */
    private $icon = null;

    /**
     * Setting a custom Username or Icon is not required.
     * If they are not provided slack will fallback to the default settings from the configuration in slack.
     *
     * @param UsernameInterface|null $username
     * @param IconInterface|null $icon
     */
    public function __construct(UsernameInterface $username = null, IconInterface $icon = null)
    {
        $this->username = $username;
        $this->icon = $icon;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function hasUsername()
    {
        return $this->username !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * {@inheritdoc}
     */
    public function hasIcon()
    {
        return $this->icon !== null;
    }
}
