<?php

/**
 * This file is part of web3php package.
 * 
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * 
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm\Providers;

use Kdm\RequestManagers\RequestManager;

class Provider
{
    /**
     * requestManager
     * 
     * @var \Kdm\RequestManagers\RequestManager
     */
    protected $requestManager;

    /**
     * isBatch
     * 
     * @var bool
     */
    protected $isBatch = false;

    /**
     * batch
     * 
     * @var array
     */
    protected $batch = [];

    /**
     * rpcVersion
     * 
     * @var string
     */
    protected $rpcVersion = '2.0';

    /**
     * id
     * 
     * @var integer
     */
    protected $id = 0;

    /**
     * construct
     * 
     * @param \Kdm\RequestManagers\RequestManager $requestManager
     * @return void
     */
    public function __construct(RequestManager $requestManager)
    {
        $this->requestManager = $requestManager;
    }

    /**
     * get
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], []);
        }
        return false;
    }

    /**
     * set
     * 
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], [$value]);
        }
        return false;
    }

    /**
     * getRequestManager
     * 
     * @return \Kdm\RequestManagers\RequestManager
     */
    public function getRequestManager()
    {
        return $this->requestManager;
    }

    /**
     * getIsBatch
     * 
     * @return bool
     */
    public function getIsBatch()
    {
        return $this->isBatch;
    }
}
