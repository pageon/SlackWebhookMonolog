<?php

namespace Pageon\SlackWebhookMonolog\General;

use Pageon\SlackWebhookMonolog\General\Exceptions\InvalidUrlException;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
 */
class Url extends SerializeToString
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->setUrl($url);
    }

    /**
     * @param string $url
     *
     * @throws InvalidUrlException Thrown when the url is not valid
     *
     * @return $this
     */
    private function setUrl($url)
    {
        // remove the whitespace
        $url = trim($url);

        // @see https://gist.github.com/dperini/729294 and https://mathiasbynens.be/demo/url-regex
        $urlValidationRegex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';
        if (!preg_match($urlValidationRegex, $url)) {
            throw new InvalidUrlException(sprintf('The url: "%s" is not a valid url.', $url), 400);
        }
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}
