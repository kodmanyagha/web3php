<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\RequestManagers;

interface IRequestManager
{
    /**
     * sendPayload
     * 
     * @param string $payload
     * @param callable $callback
     * @return void
     */
    public function sendPayload($payload, $callback);
}
