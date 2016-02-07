<?php

namespace Pageon\SlackWebhookMonolog\Monolog;

use Monolog\Handler\AbstractHandler;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\SocketHandler;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ConfigInterface as MonologConfig;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface as SlackConfig;
use Monolog\Handler\Curl;

/**
 * @author Jelmer Prins <jelmer@pageon.be>
 *
 * @since 0.1.0
 */
class SlackWebhookHandler extends AbstractProcessingHandler
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
     * @param SlackConfig $slackConfig
     * @param MonologConfig $monologConfig
     *
     * @throws MissingExtensionException When the curl extension is not activated
     */
    public function __construct(SlackConfig $slackConfig, MonologConfig $monologConfig)
    {
        if (!in_array('curl', get_loaded_extensions())) {
            throw new MissingExtensionException('The curl extension is required to use the SlackHandler');
        }

        $this->slackConfig = $slackConfig;
        $this->monologConfig = $monologConfig;

        parent::__construct($monologConfig->getLevel(), $monologConfig->doesBubble());
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $record)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->slackConfig->getWebhook());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->prepareContentData($record));

        Curl\Util::execute($ch);
    }

    /**
     * Prepares content data.
     *
     * @param array $record
     *
     * @return array
     */
    private function prepareContentData($record)
    {
        $payload = [
            'text' => $record['message'],
        ];

        return [
            'payload' => json_encode($payload),
        ];
    }
}
