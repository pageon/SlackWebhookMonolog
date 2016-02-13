<?php

namespace Pageon\SlackWebhookMonolog\Slack\Attachment;

use JsonSerializable;
use Monolog\Logger;
use Pageon\SlackWebhookMonolog\General\Url;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;
use Pageon\SlackWebhookMonolog\Slack\StringFormat;

/**
 * An attachment containing basic info about the error.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.4.0
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

    private function parseTraceItem(array $traceItem)
    {
        $text = '';
        $info = [
            'file' => isset($traceItem['file']) ? $traceItem['file'] : 'unknown',
            'function' => isset($traceItem['function']) ? $traceItem['function'] : 'unknown',
            'line' => isset($traceItem['line']) ? $traceItem['line'] : 'unknown',
            'class' => isset($traceItem['class']) ? $traceItem['class'] : 'unknown',
            'type' => isset($traceItem['type']) ? $traceItem['type'] : 'unknown',
            'arguments' => isset($traceItem['args']) ?
                "\n" . $this->formatter->arrayToKeyValueList(
                    array_map(
                        function ($item) {
                            return print_r($item, true);
                        },
                        array_filter(
                            $traceItem['args'],
                            function ($item) {
                                return !empty($item);
                            }
                        )
                    )
                ) : 'unknown',
        ];
        $text .= $this->formatter->arrayToKeyValueList($info);

        return "\n" . $this->formatter->indent($text);
    }
}
