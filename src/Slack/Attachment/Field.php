<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;

/**
 * Will be displayed in a table inside the message attachment.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
 */
final class Field implements JsonSerializable
{
    /**
     * Shown as a bold heading above the value text.
     * It cannot contain markup and will be escaped for you.
     *
     * @var string
     */
    private $title;

    /**
     * The text value of the field.
     * It may contain standard message markup and must be escaped as normal.
     * May be multi-line.
     *
     * @var string
     */
    private $value;

    /**
     * An optional flag indicating whether the value is short enough to be displayed side-by-side with other values.
     *
     * @var bool
     */
    private $short;

    /**
     * AttachmentField constructor.
     *
     * @param string $title
     * @param string $value
     * @param bool $short
     */
    public function __construct($title, $value, $short = false)
    {
        $this->title = $title;
        $this->value = $value;
        $this->short = $short;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
            'short' => $this->short,
        ];
    }
}
