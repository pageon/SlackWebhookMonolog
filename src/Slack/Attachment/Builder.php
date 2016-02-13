<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Pageon\SlackWebhookMonolog\General\SerializeToString;
use Pageon\SlackWebhookMonolog\General\Url;

/**
 * This will turn the attachment info something we can send to slack.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
 */
final class Builder
{
    /**
     * @var Attachment
     */
    private $attachment;

    /**
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Get the attachment in the format that slack requires.
     *
     * @return array
     */
    public function build()
    {
        $attachment = [
            'fallback' => $this->attachment->getFallback()
        ];

        $attachment = $this->addColourToAttachment($attachment);
        $attachment = $this->addTextToAttachment($attachment);
        $attachment = $this->addPretextToAttachment($attachment);
        $attachment = $this->addAuthorToAttachment($attachment);
        $attachment = $this->addTitleToAttachment($attachment);
        $attachment = $this->addFieldsToAttachment($attachment);
        $attachment = $this->addImageToAttachment($attachment);
        $attachment = $this->addThumbnailToAttachment($attachment);
        $attachment = $this->addMarkdownSettingsToAttachment($attachment);

        return $attachment;
    }

    /**
     * If set, add the colour to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addColourToAttachment(array $attachment)
    {
        if (!$this->attachment->hasColour()) {
            return $attachment;
        }

        $attachment['color'] = $this->attachment->getColour();

        return $attachment;
    }

    /**
     * If set, add the text to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addTextToAttachment(array $attachment)
    {
        if (!$this->attachment->hasText()) {
            return $attachment;
        }

        $attachment['text'] = $this->attachment->getText();

        return $attachment;
    }

    /**
     * If set, add the pretext to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addPretextToAttachment(array $attachment)
    {
        if (!$this->attachment->hasPretext()) {
            return $attachment;
        }

        $attachment['pretext'] = $this->attachment->getPretext();

        return $attachment;
    }

    /**
     * If set, add the author to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addAuthorToAttachment(array $attachment)
    {
        if (!$this->attachment->hasAuthor()) {
            return $attachment;
        }

        $attachment['author_name'] = $this->attachment->getAuthor();

        if ($this->attachment->getAuthor()->hasIcon()) {
            $attachment['author_icon'] = $this->attachment->getAuthor()->getIcon();
        }

        if ($this->attachment->getAuthor()->hasLink()) {
            $attachment['author_link'] = $this->attachment->getAuthor()->getLink();
        }

        return $attachment;
    }

    /**
     * If set, add the title to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addTitleToAttachment(array $attachment)
    {
        if (!$this->attachment->hasTitle()) {
            return $attachment;
        }

        $attachment['title'] = $this->attachment->getTitle();

        if ($this->attachment->getTitle()->hasLink()) {
            $attachment['title_link'] = $this->attachment->getTitle()->getLink();
        }

        return $attachment;
    }

    /**
     * If set, add the fields to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addFieldsToAttachment(array $attachment)
    {
        if (!$this->attachment->hasFields()) {
            return $attachment;
        }

        $attachment['fields'] = $this->attachment->getFields();

        return $attachment;
    }

    /**
     * If set, add the image to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addImageToAttachment(array $attachment)
    {
        if (!$this->attachment->hasImage()) {
            return $attachment;
        }

        $attachment['image_url'] = $this->attachment->getImage();

        return $attachment;
    }

    /**
     * If set, add the thumbnail to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addThumbnailToAttachment(array $attachment)
    {
        if (!$this->attachment->hasThumbnail()) {
            return $attachment;
        }

        $attachment['thumb_url'] = $this->attachment->getThumbnail();

        return $attachment;
    }

    /**
     * If set, add the fields to the attachment.
     *
     * @param array $attachment
     *
     * @return array
     */
    private function addMarkdownSettingsToAttachment(array $attachment)
    {
        if (empty($this->attachment->hasMarkdownSettings())) {
            return $attachment;
        }

        $attachment['mrkdwn_in'] = $this->attachment->getMarkdownSettings();

        return $attachment;
    }
}
