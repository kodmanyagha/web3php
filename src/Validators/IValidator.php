<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Validators;

interface IValidator
{
    /**
     * validate
     *
     * @param mixed $value
     * @return bool
     */
     public static function validate($value);
}
