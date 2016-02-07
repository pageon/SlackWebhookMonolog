<?php

namespace Pageon\SlackWebhookMonolog\Monolog;

use Monolog\Handler\AbstractHandler;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\SocketHandler;
use Pageon\SlackWebhookMonolog\Monolog\Interfaces\ConfigInterface as MonologConfig;
use Pageon\SlackWebhookMonolog\Slack\Interfaces\ConfigInterface as SlackConfig;
use Monolog\Handler\Curl;
use Pageon\SlackWebhookMonolog\Slack\Payload;

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
     * @var Curl\Util
     */
    private $curlUtil;

    /**
     * SlackWebhookHandler constructor.
     *
     * @param SlackConfig $slackConfig
     * @param MonologConfig $monologConfig
     *
     * @throws MissingExtensionException When the curl extension is not activated
     */
    public function __construct(SlackConfig $slackConfig, MonologConfig $monologConfig, Curl\Util $curlUtil)
    {
        if (!in_array('curl', get_loaded_extensions())) {
            throw new MissingExtensionException('The curl extension is required to use the SlackHandler');
        }

        parent::__construct($monologConfig->getLevel(), $monologConfig->doesBubble());

        $this->slackConfig = $slackConfig;
        $this->monologConfig = $monologConfig;
        $this->curlUtil = $curlUtil;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $record)
    {
        $curlUtil = $this->curlUtil;

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $this->slackConfig->getWebhook());
        curl_setopt($curlSession, CURLOPT_POST, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, $this->getPayload($record));

        // we return this because our mock will return the curl session
        return $curlUtil::execute($curlSession);
    }

    /**
     * Prepares content data.
     *
     * @param array $record
     *
     * @return array
     */
    private function getPayload($record)
    {
        return [
            'payload' => json_encode(
                new Payload($record)
            ),
        ];
    }
}
