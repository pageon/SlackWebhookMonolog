<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use JsonSerializable;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;
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

        $this->setMessage();

        if ($this->slackConfig === null) {
            return;
        }

        $this->setChannel();
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

    /**
     * Check if we have the extra error data.
     *
     * @return bool
     */
    private function hasErrorData()
    {
        return $this->errorData !== null;
    }

    private function setMessage()
    {
        $this->payload['text'] = sprintf(
            '*%s:* %s',
            $this->record['level_name'],
            $this->hasErrorData() ? $this->errorData->getMessage() : $this->record['message']
        );
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->payload;
    }
}
