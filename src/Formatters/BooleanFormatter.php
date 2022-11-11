<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Formatters;

use InvalidArgumentException;
use Kdm\Utils;
use Kdm\Formatters\IFormatter;

class BooleanFormatter implements IFormatter
{
    /**
     * format
     * 
     * @param mixed $value
     * @return bool
     */
    public static function format($value)
    {
        return (bool) $value;
    }
}
