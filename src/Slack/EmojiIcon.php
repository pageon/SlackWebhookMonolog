<?php

namespace Pageon\SlackMonolog\Slack;

use Pageon\SlackMonolog\Slack\Exceptions\InvalidEmojiException;
use Pageon\SlackMonolog\Slack\Interfaces\IconInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class EmojiIcon implements IconInterface
{
    /**
     * @var string
     */
    private $emoji;

    /**
     * UrlIcon constructor.
     *
     * @param string $emoji
     */
    public function __construct($emoji)
    {
        $this->setEmoji($emoji);
    }

    /**
     * This will set the emoji if it is valid.
     *
     * @param string $emoji
     *
     * @throws InvalidEmojiException Thrown when the emoji is not valid
     *
     * @return $this
     */
    private function setEmoji($emoji)
    {
        // remove the whitespace
        $emoji = trim($emoji);

        $emojiValidationRegex = '_^:[\w-+]+:$_iuS';
        if (!preg_match($emojiValidationRegex, $emoji)) {
            throw new InvalidEmojiException(sprintf('The emoji: "%s" is not a valid emoji.', $emoji), 400);
        }
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return $this->emoji;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getIcon();
    }
}
