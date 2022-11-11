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
use Kdm\Validators\NonceValidator;
use Kdm\Validators\BlockHashValidator;
use Kdm\Formatters\QuantityFormatter;

class SubmitWork extends EthMethod
{
    /**
     * validators
     * 
     * @var array
     */
    protected $validators = [
        NonceValidator::class, BlockHashValidator::class, BlockHashValidator::class
    ];

    /**
     * inputFormatters
     * 
     * @var array
     */
    protected $inputFormatters = [
        QuantityFormatter::class
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
