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

class StringFormatter implements IFormatter
{
    /**
     * format
     * 
     * @param mixed $value
     * @return string
     */
    public static function format($value)
    {
        return Utils::toString($value);
    }
}
