<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Methods\Eth;

use InvalidArgumentException;
use Kdm\Methods\EthMethod;
use Kdm\Formatters\BigNumberFormatter;

class GasPrice extends EthMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [];

    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [];

    /**
     * outputFormatters
     * 
     * @var array
     */
    protected $outputFormatters = [
        BigNumberFormatter::class
    ];

    /**
     * defaultValues
     * 
     * @var array
     */
    protected $defaultValues = [];

    /**
     * construct
     * 
     * @param string $method
     * @param array $arguments
     * @return void
     */
    // public function __construct($method='', $arguments=[])
    // {
    //     parent::__construct($method, $arguments);
    // }
}
