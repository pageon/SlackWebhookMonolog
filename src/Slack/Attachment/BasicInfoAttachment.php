<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;
use Monolog\Logger;
use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;

/**
 * An attachment containing basic info about the error.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
 */
class BasicInfoAttachment extends Attachment
{
    /**
     * @var array The data from the error handler
     */
    private $record;

    /**
     * Extra error data.
     *
     * @var ErrorInterface
     */
    private $error;

    /**
     * BasicInfoAttachment constructor.
     *
     * @param array $record
     * @param ErrorInterface $error
     */
    public function __construct(array $record, ErrorInterface $error = null)
    {
        $this->record = $record;
        $this->error = $error;

        $message = ($this->error !== null) ? $this->error->getMessage() : $this->record['message'];
        parent::__construct(sprintf('*%s:* %s', $this->record['level_name'], $message));

        $this->setColour($this->getColour());
    }

    /**
     * Returned a Slack message attachment color associated with
     * provided level.
     *
     * @return Colour
     */
    private function getColour()
    {
        switch (true) {
            case $this->record['level'] >= Logger::ERROR:
                return new Colour('danger');
            case $this->record['level'] >= Logger::WARNING:
                return new Colour('warning');
            case $this->record['level'] >= Logger::INFO:
                return new Colour('good');
            default:
                return new Colour('#e3e4e6');
        }
    }
}
