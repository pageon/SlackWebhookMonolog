<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;
use Pageon\SlackWebhookMonolog\General\Url;

/**
 * A more richly-formatted message.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
 */
class Attachment implements JsonSerializable
{
    /**
     * The attachment itself.
     * We enable markdown in everything, why wouldn't we?
     *
     * @var array
     */
    private $attachment = ['mrkdwn_in' => ['pretext', 'text', 'fields']];

    /**
     * Attachment constructor.
     * I opted for setters since there are so many optional parameters.
     * A new instance would look be messy if you only needed the last optional parameter.
     *
     * @param string $fallback A plain-text summary of the attachment.
     */
    public function __construct($fallback)
    {
        if (empty($fallback)) {
            throw new \InvalidArgumentException('The fallback is required');
        }

        $this->attachment['fallback'] = $fallback;
    }

    /**
     * This is the main text in a message attachment.
     *
     * @param string $text
     *
     * @return self
     */
    public function setText($text)
    {
        $this->attachment['text'] = $text;

        return $this;
    }

    /**
     * This value is used to color the border along the left side of the message attachment.
     *
     * @param Colour $colour
     *
     * @return self
     */
    public function setColour(Colour $colour)
    {
        $this->attachment['color'] = $colour;

        return $this;
    }

    /**
     * This is optional text that appears above the message attachment block.
     *
     * @param string $pretext
     *
     * @return self
     */
    public function setPretext($pretext)
    {
        $this->attachment['pretext'] = $pretext;

        return $this;
    }

    /**
     * The author parameters will display a small section at the top of a message attachment.
     *
     * @param Author $author
     *
     * @return self
     */
    public function setAuthor(Author $author)
    {
        $this->attachment['author_name'] = $author;

        if ($author->hasIcon()) {
            $this->attachment['author_icon'] = $author->getIcon();
        }

        if ($author->hasLink()) {
            $this->attachment['author_link'] = $author->getLink();
        }

        return $this;
    }

    /**
     * The title is displayed as larger, bold text near the top of a message attachment.
     *
     * @param Title $title
     *
     * @return self
     */
    public function setTitle(Title $title)
    {
        $this->attachment['title'] = $title;

        if ($title->hasLink()) {
            $this->attachment['title_link'] = $title->getLink();
        }

        return $this;
    }

    /**
     * Will be displayed in a table inside the message attachment.
     *
     * @param Field $field
     *
     * @return self
     */
    public function addField(Field $field)
    {
        if (!isset($this->attachment['fields'])) {
            $this->attachment['fields'] = [];
        }

        $this->attachment['fields'][] = $field;

        return $this;
    }

    /**
     * Add multiple fields in 1 call.
     *
     * @param Field[] $fields
     *
     * @return self
     */
    public function addFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * A valid URL to an image file that will be displayed inside a message attachment.
     *
     * @param Url $image
     *
     * @return self
     */
    public function setImage(Url $image)
    {
        $this->attachment['image_url'] = $image;

        return $this;
    }

    /**
     * A valid URL to an image file that will be displayed as a thumbnail on the right side of a message attachment.
     *
     * @param Url $thumbnail
     *
     * @return self
     */
    public function setThumbnail(Url $thumbnail)
    {
        $this->attachment['thumb_url'] = $thumbnail;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->get();
    }

    /**
     * Get the attachment in the format that slack requires.
     *
     * @return array
     */
    public function get()
    {
        return $this->attachment;
    }
}
