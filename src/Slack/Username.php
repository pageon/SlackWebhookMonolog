<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Interfaces\UsernameInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class Username implements UsernameInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * Username constructor.
     *
     * @param string $username
     */
    public function __construct($username)
    {
        $this->setUsername($username);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return self
     */
    private function setUsername($username)
    {
        $this->username = trim($username);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getUsername();
    }
}
