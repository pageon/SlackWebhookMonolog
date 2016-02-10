<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;
use Pageon\SlackWebhookMonolog\Slack\Exceptions\InvalidColourException;

/**
 * An optional value that can either be one of good, warning, danger, or any hex color code (eg. #439FE0).
 * This value is used to color the border along the left side of the message attachment.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
 */
final class Colour implements JsonSerializable
{
    const COLOUR_GOOD = 'good';
    const COLOUR_WARNING = 'warning';
    const COLOUR_DANGER = 'danger';

    /**
     * @var string
     */
    private $colour;

    /**
     * @param string $colour
     */
    public function __construct($colour)
    {
        $this->setColour($colour);
    }

    /**
     * Set the colour if it is a valid colour.
     *
     * @param $colour
     */
    private function setColour($colour)
    {
        if (!in_array($colour, $this->getDefaultColours()) &&
            !preg_match(
                '_^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$_',
                $colour
            )
        ) {
            throw new InvalidColourException(
                sprintf(
                    'The colour "%s" is not a valid colour. Possible options are "%s" or a valid hex colour',
                    $colour,
                    implode('", "', $this->getDefaultColours())
                )
            );
        }

        $this->colour = $colour;
    }

    /**
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getColour();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return (string) $this;
    }

    /**
     * Get the possible default colours.
     *
     * @return array
     */
    private function getDefaultColours()
    {
        return [
            self::COLOUR_GOOD,
            self::COLOUR_WARNING,
            self::COLOUR_DANGER,
        ];
    }
}
