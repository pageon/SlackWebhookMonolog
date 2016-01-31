<?php

namespace Pageon\SlackMonolog\Slack\Interfaces;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
interface UserInterface
{
    /**
     * @return UsernameInterface|null
     */
    public function getUsername();

    /**
     * Returns whether there is a custom Username.
     *
     * @return bool
     */
    public function hasUsername();

    /**
     * @return IconInterface|null
     */
    public function getIcon();

    /**
     * Returns whether there is a custom Icon.
     *
     * @return bool
     */
    public function hasIcon();
}
