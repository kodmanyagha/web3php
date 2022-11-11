<?php

/**
 * This file is part of web3php package.
 *
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 *
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Methods\Personal;

use Kdm\Methods\EthMethod;
use Kdm\Validators\StringValidator;
use Kdm\Formatters\StringFormatter;

class ImportRawKey extends EthMethod
{
    /**
     * validators
     *
     * @var array
     */
    protected $validators = [
        StringValidator::class,
        StringValidator::class,
    ];

    /**
     * inputFormatters
     *
     * @var array
     */
    protected $inputFormatters = [
        StringFormatter::class,
        StringFormatter::class,
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
     *
     * @return void
     */
    // public function __construct($method='', $arguments=[])
    // {
    //     parent::__construct($method, $arguments);
    // }
}
