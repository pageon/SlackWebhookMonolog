<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;
use Pageon\SlackWebhookMonolog\Slack\StringFormat;

/**
 * An attachment containing the trace the error.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.1
 */
class TraceAttachment extends Attachment
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
     * TraceAttachment constructor.
     *
     * @param ErrorInterface $error
     * @param StringFormat $formatter
     */
    public function __construct(ErrorInterface $error, StringFormat $formatter)
    {
        parent::__construct('Trace');
        $this->error = $error;
        $this->formatter = $formatter;

        $this->setTitle(new Title('Trace'));
        $this->setText(
            $formatter->arrayToNumberedList(
                array_map(
                    function ($traceItem) {
                        return $this->parseTraceItem($traceItem);
                    },
                    $this->error->getTrace()
                )
            )
        );
    }

    /**
     * Parse all the data into the markup of slack.
     *
     * @param array $traceItem
     *
     * @return string
     */
    private function parseTraceItem(array $traceItem)
    {
        $text = '';
        $info = [
            'file' => $this->getArrayValue($traceItem, 'file', 'unknown'),
            'function' => $this->getArrayValue($traceItem, 'function', 'unknown'),
            'line' => $this->getArrayValue($traceItem, 'line', 'unknown'),
            'class' => $this->getArrayValue($traceItem, 'class', 'unknown'),
            'type' => $this->getArrayValue($traceItem, 'type', 'unknown'),
        ];
        $text .= $this->formatter->arrayToKeyValueList($info);

        return "\n" . $this->formatter->indent($text);
    }

    /**
     * @param array $array
     * @param string $key
     * @param mixed|null $fallback
     *
     * @return mixed
     */
    private function getArrayValue(array $array, $key, $fallback = null)
    {
        return isset($array[$key]) ? $array[$key] : $fallback;
    }
}
