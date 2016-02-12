<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\UserInterface;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\WebhookInterface;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
 */
final class StringFormat
{
    /**
     * There are three characters you must convert to HTML entities and only three: &, <, and >.
     * Don't HTML entity-encode the entire message, Slack will take care of the rest.
     * This function will do that for you.
     *
     * @param string $unescapedText
     *
     * @return string
     */
    public function escape($unescapedText)
    {
        return str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], $unescapedText);
    }

    /**
     * This will emphasis the string by wrapping it between *
     *
     * @param string $text
     *
     * @return string
     */
    public function emphasis($text)
    {
        return $this->wrapStringWith($text, '*');
    }

    /**
     * This will italicize the string by wrapping it between _
     *
     * @param string $text
     *
     * @return string
     */
    public function italicize($text)
    {
        return $this->wrapStringWith($text, '_');
    }

    /**
     * This will strikethrough the string by wrapping it between ~
     *
     * @param string $text
     *
     * @return string
     */
    public function strikethrough($text)
    {
        return $this->wrapStringWith($text, '~');
    }

    /**
     * Create a block of pre-formatted, fixed-width text
     *
     * @param string $text
     *
     * @return string
     */
    public function pre($text)
    {
        return $this->wrapStringWith($text, '```');
    }

    /**
     * Display as inline fixed-width text.
     *
     * @param string $text
     *
     * @return string
     */
    public function code($text)
    {
        return $this->wrapStringWith($text, '`');
    }

    /**
     * Indent the text.
     * Because multi line indenting can't be closed in slack we implemented it for you.
     * When you use a new line it will be indented as well.
     *
     * @param string $text
     *
     * @return string
     */
    public function indent($text)
    {
        return '>' . str_replace('\n', '\n>', $text);
    }

    /**
     * This will generate a numbered list from an array.
     *
     * @param array $listItems
     *
     * @return string
     */
    public function arrayToNumberedList(array $listItems)
    {
        $formattedList = '';
        $number = 1;

        foreach ($listItems as $listItem) {
            $formattedList .= sprintf('%d. %s\n', $number++, (string) $listItem);
        }

        return $formattedList;
    }

    /**
     * This will generate a bullet list from an array.
     *
     * @param array $listItems
     * @param string $bulletCharacter The character used as bullet
     *
     * @return string
     */
    public function arrayToBulletList(array $listItems, $bulletCharacter = '•')
    {
        $formattedList = '';

        foreach ($listItems as $listItem) {
            $formattedList .= sprintf('%s %s\n', $bulletCharacter, (string) $listItem);
        }

        return $formattedList;
    }

    /**
     * Wraps a string with a wrapper string.
     *
     * @param string $text
     * @param string $wrapper
     *
     * @return string
     */
    private function wrapStringWith($text, $wrapper)
    {
        return sprintf('%1$s%2$s%1$s', $wrapper, $text);
    }
}
