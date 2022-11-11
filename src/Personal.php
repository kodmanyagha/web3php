<?php

/**
 * This file is part of web3php package.
 *
 * (c) Emir Bugra Koksalan <kodmanyagha@gmail.com>
 *
 * @author Emir Bugra Koksalan <kodmanyagha@gmail.com>
 * @license MIT
 */

namespace Kdm;

use Kdm\Providers\Provider;
use Kdm\Providers\HttpProvider;
use Kdm\RequestManagers\HttpRequestManager;

/**
 * @method listAccounts(callable $callback)
 * @method newAccount(callable $callback)
 * @method unlockAccount(callable $callback)
 * @method lockAccount(callable $callback)
 * @method sendTransaction(callable $callback)
 * @method importRawKey(string $address, string $password, callable $callback)
 */
class Personal
{
    /**
     * provider
     *
     * @var \Kdm\Providers\Provider
     */
    protected $provider;

    /**
     * methods
     *
     * @var array
     */
    private $methods = [];

    /**
     * allowedMethods
     *
     * @var array
     */
    private $allowedMethods = [
        'personal_listAccounts', 'personal_newAccount', 'personal_unlockAccount', 'personal_lockAccount',
        'personal_sendTransaction', 'personal_importRawKey',
    ];

    /**
     * construct
     *
     * @param string|\Kdm\Providers\Provider $provider
     *
     * @return void
     */
    public function __construct($provider)
    {
        if (is_string($provider) && (filter_var($provider, FILTER_VALIDATE_URL) !== false)) {
            // check the uri schema
            if (preg_match('/^https?:\/\//', $provider) === 1) {
                $requestManager = new HttpRequestManager($provider);

                $this->provider = new HttpProvider($requestManager);
            }
        } elseif ($provider instanceof Provider) {
            $this->provider = $provider;
        }
    }

    /**
     * call
     *
     * @param string $name
     * @param array $arguments
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        if (empty($this->provider)) {
            throw new \RuntimeException('Please set provider first.');
        }

        $class = explode('\\', get_class());

        if (preg_match('/^[a-zA-Z0-9]+$/', $name) === 1) {
            $method = strtolower($class[1]) . '_' . $name;

            if (!in_array($method, $this->allowedMethods)) {
                throw new \RuntimeException('Unallowed rpc method: ' . $method);
            }
            if ($this->provider->isBatch) {
                $callback = null;
            } else {
                $callback = array_pop($arguments);

                if (is_callable($callback) !== true) {
                    throw new \InvalidArgumentException('The last param must be callback function.');
                }
            }
            if (!array_key_exists($method, $this->methods)) {
                // new the method
                $methodClass            = sprintf("\Kdm\Methods\%s\%s", ucfirst($class[1]), ucfirst($name));
                $methodObject           = new $methodClass($method, $arguments);
                $this->methods[$method] = $methodObject;
            } else {
                $methodObject = $this->methods[$method];
            }
            if ($methodObject->validate($arguments)) {
                $inputs                  = $methodObject->transform($arguments, $methodObject->inputFormatters);
                $methodObject->arguments = $inputs;
                $this->provider->send($methodObject, $callback);
            }
        }
    }

    /**
     * get
     *
     * @param string $name
     *
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
     *
     * @return mixed
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
     * getProvider
     *
     * @return \Kdm\Providers\Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * setProvider
     *
     * @param \Kdm\Providers\Provider $provider
     *
     * @return bool
     */
    public function setProvider($provider)
    {
        if ($provider instanceof Provider) {
            $this->provider = $provider;
            return true;
        }
        return false;
    }

    /**
     * batch
     *
     * @param bool $status
     *
     * @return void
     */
    public function batch($status)
    {
        $status = is_bool($status);

        $this->provider->batch($status);
    }
}
