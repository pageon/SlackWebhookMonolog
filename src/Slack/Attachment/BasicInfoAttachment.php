<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Monolog\Logger;
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
        parent::__construct($message);

        $this->setColour($this->getColourForLoggerLevel());
        $this->setText(sprintf('*Error:* %s', $this->record['level_name']));
        $this->addField(new Field('What', $message));

        $this->addField(new Field('When', $this->record['datetime']->format('d/m/Y H:i:s'), true));

        $this->addRecordDataAsJsonEncodedField('context', 'Context');
        $this->addRecordDataAsJsonEncodedField('extra', 'Extra');

        if ($this->error !== null) {
            $this->addField(new Field('Line', $this->error->getLine(), true));
            $this->addField(new Field('File', $this->error->getFile()));
        }
    }

    /**
     * Check if a key is available in the record. If so, add it as a field.
     *
     * @param string $key
     * @param string $label
     */
    private function addRecordDataAsJsonEncodedField($key, $label)
    {
        if (!empty($this->record[$key])) {
            $this->addField(new Field($label, json_encode($this->record[$key])));
        }
    }

    /**
     * Returned a Slack message attachment color associated with
     * provided level.
     *
     * @return Colour
     */
    private function getColourForLoggerLevel()
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
