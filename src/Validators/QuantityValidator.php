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

use Kdm\Validators\IValidator;

class QuantityValidator
{
    /**
     * validate
     *
     * @param string $value
     * @return bool
     */
    public static function validate($value)
    {
        // maybe change is_int and is_float and preg_match future
        return (is_int($value) || is_float($value) || preg_match('/^0x[a-fA-F0-9]*$/', $value) >= 1);
    }
}
