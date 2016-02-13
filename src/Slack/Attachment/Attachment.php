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
final class Attachment implements JsonSerializable
{
    /**
     * A plain-text summary of the attachment.
     * This text will be used in clients that don't show formatted text (eg. IRC, mobile notifications).
     * It should not contain any markup.
     *
     * @var string
     */
    private $fallback;

    /**
     * This is the main text in a message attachment, and can contain standard message markup.
     * The content will automatically collapse if it contains 700+ characters or 5+ linebreaks,
     * and will display a "Show more..." link to expand the content.
     *
     * @var string|null
     */
    private $text = null;

    /**
     * This value is used to color the border along the left side of the message attachment.
     *
     * @var Colour|null
     */
    private $colour = null;

    /**
     * This is optional text that appears above the message attachment block.
     *
     * @var string|null
     */
    private $pretext = null;

    /**
     * The author parameters will display a small section at the top of a message attachment.
     *
     * @var Author|null
     */
    private $author = null;

    /**
     * The title is displayed as larger, bold text near the top of a message attachment.
     * By passing a valid URL in the link parameter (optional), the title will be hyperlinked.
     *
     * @var Title|null
     */
    private $title = null;

    /**
     * Will be displayed in a table inside the message attachment.
     *
     * @var Field[]
     */
    private $fields = [];

    /**
     * A valid URL to an image file that will be displayed inside a message attachment.
     * We currently support the following formats: GIF, JPEG, PNG, and BMP.
     * Large images will be resized to a maximum width of 400px or a maximum height of 500px,
     * while still maintaining the original aspect ratio.
     *
     * @var Url|null
     */
    private $image = null;

    /**
     * A valid URL to an image file that will be displayed as a thumbnail on the right side of a message attachment.
     * We currently support the following formats: GIF, JPEG, PNG, and BMP.
     * The thumbnail's longest dimension will be scaled down to 75px while maintaining the aspect ratio of the image.
     * The filesize of the image must also be less than 500 KB.
     *
     * @var Url|null
     */
    private $thumbnail = null;

    /**
     * By default bot message text will be formatted, but attachments are not.
     * Attachments need to enable the markdown manually.
     *
     * @var array
     */
    private $markdownIn = [];

    /**
     * Attachment constructor.
     * I opted for setters since there are so many optional parameters.
     * A new instance would look be messy if you only needed the last optional parameter.
     *
     * @param string $fallback
     */
    public function __construct($fallback)
    {
        if (empty($fallback)) {
            throw new \InvalidArgumentException('The fallback is required');
        }

        $this->fallback = $fallback;
    }

    /**
     * @return string
     */
    public function getFallback()
    {
        return $this->fallback;
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasText()
    {
        return $this->text !== null;
    }

    /**
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param Colour $colour
     *
     * @return self
     */
    public function setColour(Colour $colour)
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasColour()
    {
        return $this->colour !== null;
    }

    /**
     * @return Colour|null
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * @param string $pretext
     *
     * @return self
     */
    public function setPretext($pretext)
    {
        $this->pretext = $pretext;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasPretext()
    {
        return $this->pretext !== null;
    }

    /**
     * @return string|null
     */
    public function getPretext()
    {
        return $this->pretext;
    }

    /**
     * @param Author $author
     *
     * @return self
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasAuthor()
    {
        return $this->author !== null;
    }

    /**
     * @return Author|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Title $title
     *
     * @return self
     */
    public function setTitle(Title $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasTitle()
    {
        return $this->title !== null;
    }

    /**
     * @return Title|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @param Field[] $fields
     */
    public function addFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }
    }

    /**
     * @return bool
     */
    public function hasFields()
    {
        return !empty($this->fields);
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Url $image
     *
     * @return self
     */
    public function setImage(Url $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasImage()
    {
        return $this->image !== null;
    }

    /**
     * @return Url|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Url $thumbnail
     *
     * @return self
     */
    public function setThumbnail(Url $thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasThumbnail()
    {
        return $this->thumbnail !== null;
    }

    /**
     * @return Url|null
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Enable markdown in the pretext.
     *
     * @return $this
     */
    public function enableMarkdownForPretext()
    {
        $this->markdownIn[] = 'pretext';

        return $this;
    }

    /**
     * Enable markdown in the text.
     *
     * @return $this
     */
    public function enableMarkdownForText()
    {
        $this->markdownIn[] = 'text';

        return $this;
    }

    /**
     * Enable markdown for the value in the fields.
     *
     * @return $this
     */
    public function enableMarkdownForFieldValues()
    {
        $this->markdownIn[] = 'fields';

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMarkdownSettings()
    {
        return !empty($this->markdownIn);
    }

    /**
     * @return array
     */
    public function getMarkdownSettings()
    {
        return $this->markdownIn;
    }

    /**
     * @inheritDoc
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
        return (new Builder($this))->build();
    }
}
