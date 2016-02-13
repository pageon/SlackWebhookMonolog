# SlackWebhookMonolog
[![Build Status](https://api.travis-ci.org/Pageon/SlackWebhookMonolog.svg)](https://travis-ci.org/Pageon/SlackWebhookMonolog)
[![Latest Stable Version](https://poser.pugx.org/pageon/slack-webhook-monolog/v/stable)](https://packagist.org/packages/pageon/slack-webhook-monolog)
[![Total Downloads](https://poser.pugx.org/pageon/slack-webhook-monolog/downloads)](https://packagist.org/packages/pageon/slack-webhook-monolog)
[![License](https://poser.pugx.org/pageon/slack-webhook-monolog/license)](https://packagist.org/packages/pageon/slack-webhook-monolog)
[![Code Coverage](https://scrutinizer-ci.com/g/Pageon/SlackWebhookMonolog/badges/coverage.png?branch=master)](https://scrutinizer-ci.com/g/Pageon/SlackWebhookMonolog/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Pageon/SlackWebhookMonolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Pageon/SlackWebhookMonolog/?branch=master)
[![StyleCI](https://styleci.io/repos/50748390/shield)](https://styleci.io/repos/50748390)

In monolog there is already a slack integration using the api but that takes up an integration slot.
If you are on the free plan you only have limited integration slots (10).
In order to be able to use slack for monolog I implemented it using webhooks.

## Usage

As simple as pushing your `\Pageon\SlackWebhookMonolog\Monolog\SlackWebhookHandler` as a handler to Monolog

## Example of message in Slack
![example](example.png?raw=true)
