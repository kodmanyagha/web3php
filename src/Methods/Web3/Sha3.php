<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Methods\Web3;

use InvalidArgumentException;
use Kdm\Methods\EthMethod;
use Kdm\Formatters\HexFormatter;
use Kdm\Validators\StringValidator;

class Sha3 extends EthMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [
        StringValidator::class
    ];

    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [
        HexFormatter::class
    ];

    /**
     * outputFormatters
     * 
     * @var array
     */
    protected $outputFormatters = [];

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
