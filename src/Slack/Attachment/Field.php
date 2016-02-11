<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.3.2
 */
final class Field implements JsonSerializable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $value;

    /**
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
