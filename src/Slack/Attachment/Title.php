<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidUrlException;

/**
 * The title is displayed as larger, bold text near the top of a message attachment.
 * By passing a valid URL in the link parameter (optional), the title text will be hyperlinked.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
 */
final class Title
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $link;

    /**
     * @param string $title
     * @param string|null $link
     */
    public function __construct($title, $link = null)
    {
        $this->setTitle($title);
        $this->setLink($link);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    private function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasLink()
    {
        return $this->link !== null;
    }

    /**
     * @return string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     *
     * @return self
     */
    private function setLink($link = null)
    {
        if ($link === null) {
            return $this;
        }

        if (!preg_match(
            '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iu',
            $link
        )
        ) {
            throw new InvalidUrlException($link . ' is not a valid url');
        }

        $this->link = $link;

        return $this;
    }
}
