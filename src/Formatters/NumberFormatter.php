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

class NumberFormatter implements IFormatter
{
    /**
     * format
     * 
     * @param mixed $value
     * @return int
     */
    public static function format($value)
    {
        $value = Utils::toString($value);
        $bn = Utils::toBn($value);
        $int = (int) $bn->toString();

        return $int;
    }
}
