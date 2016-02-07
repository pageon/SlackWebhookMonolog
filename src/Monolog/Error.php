<?php

namespace Pageon\SlackWebhookMonolog\Monolog;

use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ErrorInterface;

/**
 * A custom error class to collect all the data we need.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 */
class Error implements ErrorInterface
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $line;

    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $trace;

    /**
     * @var array
     */
    private $parameters = array();

    /**
     * Create a new error wrapping the given error context info.
     *
     * @param string $message
     * @param int $line
     * @param string $file
     * @param array|null $trace
     * @param array|null $parameters
     */
    public function __construct($message, $line, $file, array $trace = null, array $parameters = null)
    {
        $this->setMessage($message);
        $this->setLine($line);
        $this->setFile($file);
        $this->setTrace($trace);
        $this->setParameters($parameters);
    }

    /**
     * @param string $file
     */
    private function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param int $line
     */
    private function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param string $message
     */
    private function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param array|null $parameters
     */
    private function setParameters(array $parameters = null)
    {
        $this->parameters = $parameters;

        // make sure we have at least the POST, GET, COOKIE and SESSION data
        $this->addParameterFallback('_POST', $_POST);
        $this->addParameterFallback('_GET', $_GET);
        $this->addParameterFallback('_COOKIE', $_COOKIE);
        if (isset($_SESSION)) {
            $this->addParameterFallback('_SESSION', $_SESSION);
        }
    }

    /**
     * This will add fallback data to the parameters if the key is not set
     *
     * @param string $name
     * @param mixed $fallbackData
     */
    private function addParameterFallback($name, $fallbackData = null)
    {
        if (!isset($this->parameters[$name]) && !empty($fallbackData)) {
            $this->parameters[$name] = $fallbackData;
        }
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array|null $trace
     */
    private function setTrace(array $trace = null)
    {
        if ($trace === null) {
            $trace = array(
                array(
                    'line' => $this->getLine(),
                    'file' => $this->getFile(),
                    'function' => 'unknown'
                )
            );
        }
        $this->trace = $trace;
    }

    /**
     * @return array
     */
    public function getTrace()
    {
        return $this->trace;
    }
}
