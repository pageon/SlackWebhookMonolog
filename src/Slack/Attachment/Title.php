<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\SerializeToString;
use Pageon\SlackWebhookMonolog\General\Url;

/**
 * The title is displayed as larger, bold text near the top of a message attachment.
 * By passing a valid URL in the link parameter (optional), the title text will be hyperlinked.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
 */
final class Title extends SerializeToString
{
    /**
     * The title is displayed as larger, bold text near the top of a message attachment.
     *
     * @var string
     */
    private $title;

    /**
     * By passing a valid URL in the link parameter (optional), the title text will be hyperlinked.
     *
     * @var Url|null
     */
    private $link;

    /**
     * @param string $title
     * @param Url|null $link
     */
    public function __construct($title, Url $link = null)
    {
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function hasLink()
    {
        return $this->link !== null;
    }

    /**
     * @return Url|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}
