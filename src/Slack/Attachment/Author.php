<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\SerializeToString;
use Pageon\SlackWebhookMonolog\General\Url;

/**
 * The author will display a small section at the top of a message attachment.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
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
    private $url;

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
     * @param Url|null $url
     * @param Url|null $icon
     */
    public function __construct($name, Url $url = null, Url $icon = null)
    {
        $this->name = $name;
        $this->url = $url;
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
     * @return null|Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function hasUrl()
    {
        return $this->url !== null;
    }

    /**
     * @return null|Url
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return null
     */
    public function hasIcon()
    {
        return $this->icon !== null;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->getName();
    }
}
