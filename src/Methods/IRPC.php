<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Methods;

interface IRPC
{
    /**
     * __toString
     * 
     * @return array
     */
    public function __toString();

    /**
     * toPayload
     * 
     * @return array
     */
    public function toPayload();
}
