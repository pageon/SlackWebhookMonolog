<?php

namespace Pageon\SlackWebhookMonolog\Monolog;

use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\SocketHandler;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ConfigInterface as MonologConfig;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface as SlackConfig;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class SlackWebhookHandler extends SocketHandler
{
    /**
     * @var SlackConfig
     */
    private $slackConfig;

    /**
     * @var MonologConfig
     */
    private $monologConfig;

    /**
     * SlackWebhookHandler constructor.
     *
     * @param SlackConfig   $slackConfig
     * @param MonologConfig $monologConfig
     *
     * @throws MissingExtensionException When the OpenSSL PHP extension is not activated
     */
    public function __construct(SlackConfig $slackConfig, MonologConfig $monologConfig)
    {
        if (!extension_loaded('openssl')) {
            throw new MissingExtensionException('The OpenSSL PHP extension is required to use the SlackHandler');
        }

        $this->slackConfig = $slackConfig;
        $this->monologConfig = $monologConfig;

        parent::__construct(
            $monologConfig->getConnectionString(),
            $monologConfig->getLevel(),
            $monologConfig->doesBubble()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     *
     * @return string
     */
    protected function generateDataStream($record)
    {
        $content = $this->buildContent($record);

        return $this->buildHeader($content).$content;
    }

    /**
     * Builds the body of API call.
     *
     * @param array $record
     *
     * @return string
     */
    private function buildContent($record)
    {
        $dataArray = $this->prepareContentData($record);

        return http_build_query($dataArray);
    }

    /**
     * Prepares content data.
     *
     * @param array $record
     *
     * @return array
     */
    protected function prepareContentData($record)
    {
        $payload = [
            'text' => $record['message'],
        ];

        return [
            'payload' => json_encode($payload),
        ];
    }

    /**
     * Builds the header of the API Call.
     *
     * @param string $content
     *
     * @return string
     */
    private function buildHeader($content)
    {
        $header = 'POST '.$this->slackConfig->getWebhook()." HTTP/1.1\r\n";
        $header .= "Host: slack.com\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= 'Content-Length: '.strlen($content)."\r\n";
        $header .= "\r\n";

        return $header;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        parent::write($record);

        $this->closeSocket();
    }
}
