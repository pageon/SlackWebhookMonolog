<?php

namespace Pageon\SlackWebhookMonolog\Slack;

use JsonSerializable;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;

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
     * Payload constructor.
     *
     * @param $record
     */
    public function __construct(array $record)
    {
        $this->record = $record;
        $this->generatePayload();
    }

    private function generatePayload()
    {
        $this->setErrorData();

        $this->setMessage();
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
