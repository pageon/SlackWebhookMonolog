<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\SerializeToString;
use Pageon\SlackWebhookMonolog\General\Url;

/**
 * The author will display a small section at the top of a message attachment.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
 */
final class Author extends SerializeToString
{
    /**
     * Small text used to display the author's name.
     *
     * @var string
     */
    private $name;

    /**
     * A valid URL that will hyperlink the name.
     *
     * @var Url|null
     */
    private $link;

    /**
     * A valid URL that displays a small 16x16px image to the left of the name.
     *
     * @var Url|null
     */
    private $icon;

    /**
     * Author constructor.
     *
     * @param string $name
     * @param Url|null $link
     * @param Url|null $icon
     */
    public function __construct($name, Url $link = null, Url $icon = null)
    {
        $this->name = $name;
        $this->link = $link;
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Url|null
     */
    public function getLink()
    {
        return $this->link;
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
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return bool
     */
    public function hasIcon()
    {
        return $this->icon !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }
}
