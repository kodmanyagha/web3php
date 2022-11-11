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
use Kdm\Utils;

class TagValidator implements IValidator
{
    /**
     * validate
     *
     * @param string $value
     * @return bool
     */
    public static function validate($value)
    {
        $value = Utils::toString($value);
        $tags = [
            'latest', 'earliest', 'pending'
        ];

        return in_array($value, $tags);
    }
}
