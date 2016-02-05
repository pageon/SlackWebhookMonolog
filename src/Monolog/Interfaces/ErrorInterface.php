<?php

namespace Pageon\SlackWebhookMonolog\Monolog\Interfaces;

/**
 * A custom error class to collect all the data we need.
 *
 * @author Jelmer Prins <jelmer@pageon.be>
 */
interface ErrorInterface
{
    /**
     * The filename that the error was raised in.
     *
     * @return string
     */
    public function getFile();

    /**
     * The line number the error was raised at.
     *
     * @return int
     */
    public function getLine();

    /**
     * The error message.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Contains an array of variables that existed in the scope the error was triggered in.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Contents of debug_backtrace().
     *
     * @return array
     */
    public function getTrace();
}
