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
use Kdm\Validators\QuantityValidator;
use Kdm\Validators\TagValidator;
use Kdm\Validators\HexValidator;
use Kdm\Validators\AddressValidator;

class FilterValidator
{
    /**
     * validate
     *
     * @param array $value
     * @return bool
     */
    public static function validate($value)
    {
        if (!is_array($value)) {
            return false;
        }
        if (
            isset($value['fromBlock']) &&
            QuantityValidator::validate($value['fromBlock']) === false &&
            TagValidator::validate($value['fromBlock']) === false
            ) {
            return false;
        }
        if (
            isset($value['toBlock']) &&
            QuantityValidator::validate($value['toBlock']) === false &&
            TagValidator::validate($value['toBlock']) === false
            ) {
            return false;
        }
        if (isset($value['address'])) {
            if (is_array($value['address'])) {
                foreach ($value['address'] as $address) {
                    if (AddressValidator::validate($address) === false) {
                        return false;
                    }
                }
            } elseif (AddressValidator::validate($value['address']) === false) {
                return false;
            }
        }
        if (isset($value['topics']) && is_array($value['topics'])) {
            foreach ($value['topics'] as $topic) {
                if (is_array($topic)) {
                    foreach ($topic as $v) {
                        if (isset($v) && HexValidator::validate($v) === false) {
                            return false;
                        }
                    }
                } else {
                    if (isset($topic) && HexValidator::validate($topic) === false) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}
