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
use Kdm\Validators\QuantityValidator;
use Kdm\Validators\TagValidator;
use Kdm\Validators\BooleanValidator;
use Kdm\Formatters\OptionalQuantityFormatter;
use Kdm\Formatters\BooleanFormatter;

class GetBlockByNumber extends EthMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [
        [
            QuantityValidator::class, TagValidator::class
        ], BooleanValidator::class
    ];

    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [
        OptionalQuantityFormatter::class, BooleanFormatter::class
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
    protected $defaultValues = [
        0 => 'latest'
    ];

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
