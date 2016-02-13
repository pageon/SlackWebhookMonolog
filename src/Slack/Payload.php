<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use JsonSerializable;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;
use Pageon\SlackWebhookMonolog\Slack\Attachment\BasicInfoAttachment;
use Pageon\SlackWebhookMonolog\Slack\Attachment\ParametersAttachment;
use Pageon\SlackWebhookMonolog\Slack\Attachment\TraceAttachment;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface as SlackConfigInterface;

/**
 * Turns the record into a payload for slack.
 *
 * Class Payload
 *
 * @author Jelmer Prins <jelmer@$pageon.be>
 */
class Payload implements JsonSerializable
{
    /**
     * @var array The data from the error handler
     */
    private $record;

    /**
     * The data that will be send to the api.
     *
     * @var array
     */
    private $payload;

    /**
     * Extra error data.
     *
     * @var ErrorInterface
     */
    private $errorData;

    /**
     * Contains some extra information like channel and user etc that can be used in the payload.
     *
     * @var SlackConfigInterface
     */
    private $slackConfig;

    /**
     * Payload constructor.
     *
     * @param array $record
     * @param SlackConfigInterface $slackConfig
     */
    public function __construct(array $record, SlackConfigInterface $slackConfig = null)
    {
        $this->record = $record;
        $this->slackConfig = $slackConfig;

        $this->generatePayload();
    }

    private function generatePayload()
    {
        $this->setErrorData();

        $this->setAttachments();

        if ($this->slackConfig !== null) {
            $this->generatePayloadForSlackConfig();
        }
    }

    /**
     * Generate the payload for the slack config.
     */
    private function generatePayloadForSlackConfig()
    {
        $this->setChannel();

        if ($this->slackConfig->hasCustomUser()) {
            $this->generatePayloadForCustomUser();
        }
    }

    private function generatePayloadForCustomUser()
    {
        $this->setIcon();
        $this->setUsername();
    }

    /**
     * Set a custom icon if available.
     */
    private function setIcon()
    {
        if (!$this->slackConfig->getCustomUser()->hasIcon()) {
            return;
        }

        $iconType = 'icon_' . $this->slackConfig->getCustomUser()->getIcon()->getType();
        $this->payload[$iconType] = $this->slackConfig->getCustomUser()->getIcon();
    }

    /**
     * Set a custom username if available.
     */
    private function setUsername()
    {
        if (!$this->slackConfig->getCustomUser()->hasUsername()) {
            return;
        }

        $this->payload['username'] = $this->slackConfig->getCustomUser()->getUsername();
    }

    /**
     * Set a custom channel if available.
     */
    private function setChannel()
    {
        if (!$this->slackConfig->getWebhook()->hasCustomChannel()) {
            return;
        }

        $this->payload['channel'] = $this->slackConfig->getWebhook()->getCustomChannel();
    }

    /**
     * If available set the error data.
     */
    private function setErrorData()
    {
        if (!isset($this->record['context']['error'])) {
            return;
        }

        $this->errorData = $this->record['context']['error'];
    }

    private function setAttachments()
    {
        $this->payload['attachments'] = [
            new BasicInfoAttachment($this->record, $this->errorData),
        ];

        if ($this->errorData !== null) {
            $this->addErrorSpecificAttachments();
        }
    }

    private function addErrorSpecificAttachments()
    {
        $formatter = new StringFormat();
        $this->payload['attachments'][] = new TraceAttachment($this->errorData, $formatter);
        $this->payload['attachments'][] = new ParametersAttachment($this->errorData, $formatter);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->payload;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
