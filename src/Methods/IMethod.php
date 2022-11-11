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

interface IMethod
{
    /**
     * transform
     * 
     * @param array &$data
     * @param array $rules
     * @return array
     */
    public function transform($data, $rules);
}
