<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Contracts\Types;

interface IType
{
    /**
     * isType
     * 
     * @param string $name
     * @return bool
     */
    public function isType($name);

    /**
     * isDynamicType
     * 
     * @return bool
     */
    public function isDynamicType();

    /**
     * inputFormat
     * 
     * @param mixed $value
     * @param string $name
     * @return string
     */
    public function inputFormat($value, $name);
}
