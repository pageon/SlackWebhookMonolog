<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;
use Monolog\Logger;
use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;
use Pageon\SlackWebhookMonolog\Slack\StringFormat;

/**
 * An attachment containing parameters of the error.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.1
 */
class ParametersAttachment extends Attachment
{
    /**
     * Extra error data.
     *
     * @var ErrorInterface
     */
    private $error;

    /**
     * @var StringFormat
     */
    private $formatter;

    /**
     * @param ErrorInterface $error
     * @param StringFormat $formatter
     */
    public function __construct(ErrorInterface $error, StringFormat $formatter)
    {
        parent::__construct('Parameters');
        $this->error = $error;
        $this->formatter = $formatter;

        $this->setTitle(new Title('Parameters'));

        foreach ((array) $this->error->getParameters() as $name => $parameter) {
            $this->addField(new Field($name, $this->parseParameter($parameter)));
        }
    }

    /**
     * Parse all the data into the markup of slack.
     *
     * @param mixed $parameter
     *
     * @return string
     */
    private function parseParameter($parameter)
    {
        if (!is_array($parameter)) {
            return print_r($parameter, true);
        }

        return $this->parseArrayParameter($parameter);
    }

    /**
     * @param array $parameter
     *
     * @return string
     */
    private function parseArrayParameter(array $parameter)
    {
        return "\n" . $this->formatter->arrayToKeyValueList(
            array_map(
                function ($item) {
                    return print_r($item, true);
                },
                $parameter
            )
        );
    }
}
