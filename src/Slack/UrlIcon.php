<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidUrlException;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\IconInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class UrlIcon extends SerializeToString implements IconInterface
{
    /**
     * @var string
     */
    private $iconUrl;

    /**
     * UrlIcon constructor.
     *
     * @param string $iconUrl
     */
    public function __construct($iconUrl)
    {
        $this->setIcon($iconUrl);
    }

    /**
     * This will set the icon if the url is valid.
     *
     * @param string $iconUrl
     *
     * @throws InvalidUrlException Thrown when the url is not valid
     *
     * @return $this
     */
    private function setIcon($iconUrl)
    {
        // remove the whitespace
        $iconUrl = trim($iconUrl);

        // @see https://gist.github.com/dperini/729294 and https://mathiasbynens.be/demo/url-regex
        $urlValidationRegex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';
        if (!preg_match($urlValidationRegex, $iconUrl)) {
            throw new InvalidUrlException(sprintf('The url: "%s" is not a valid url.', $iconUrl), 400);
        }
        $this->iconUrl = $iconUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return $this->iconUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getIcon();
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return 'url';
    }
}
