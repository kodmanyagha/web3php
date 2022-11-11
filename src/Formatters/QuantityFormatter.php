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

class QuantityFormatter implements IFormatter
{
    /**
     * format
     * 
     * @param mixed $value
     * @return string
     */
    public static function format($value)
    {
        $value = Utils::toString($value);

        if (Utils::isZeroPrefixed($value)) {
            // test hex with zero ahead, hardcode 0x0
            if ($value === '0x0' || strpos($value, '0x0') !== 0) {
                return $value;
            }
            $hex = preg_replace('/^0x0+(?!$)/', '', $value);
        } else {
            $bn = Utils::toBn($value);
            $hex = $bn->toHex(true);
        }
        if (empty($hex)) {
            $hex = '0';
        } else {
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        }
        return '0x' . $hex;
    }
}
