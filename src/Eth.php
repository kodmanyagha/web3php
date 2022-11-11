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

use Exception;
use Kdm\Lib\OfflineTx\Transaction;
use Kdm\Providers\Provider;
use Kdm\Providers\HttpProvider;
use Kdm\RequestManagers\HttpRequestManager;

/**
 * @method protocolVersion(callable $callback)
 * @method syncing(callable $callback)
 * @method coinbase(callable $callback)
 * @method mining(callable $callback)
 * @method hashrate(callable $callback)
 * @method gasPrice(callable $callback)
 * @method accounts(callable $callback)
 * @method blockNumber(callable $callback)
 * @method getBalance(string $address, callable $callback)
 * @method getStorageAt(callable $callback)
 * @method getTransactionCount(string $address, callable $callback)
 * @method getBlockTransactionCountByHash(callable $callback)
 * @method getBlockTransactionCountByNumber(callable $callback)
 * @method getUncleCountByBlockHash(callable $callback)
 * @method getUncleCountByBlockNumber(callable $callback)
 * @method getUncleByBlockHashAndIndex(callable $callback)
 * @method getUncleByBlockNumberAndIndex(callable $callback)
 * @method getCode(callable $callback)
 * @method sign(callable $callback)
 * @method sendTransaction(callable $callback)
 * @method sendRawTransaction(string $rawTx, callable $callback)
 * @method call(mixed $object, mixed $quantityOrTag, callable $callback)
 * @method estimateGas(callable $callback)
 * @method getBlockByHash(string $hash, bool $isFullData, callable $callback)
 * @method getBlockByNumber(mixed $blockNumber, bool $isFullData, callable $callback)
 * @method getTransactionByHash(string $hash, callable $callback)
 * @method getTransactionByBlockHashAndIndex(callable $callback)
 * @method getTransactionByBlockNumberAndIndex(callable $callback)
 * @method getTransactionReceipt(callable $callback)
 * @method compileSolidity(callable $callback)
 * @method compileLLL(callable $callback)
 * @method compileSerpent(callable $callback)
 * @method getWork(callable $callback)
 * @method newFilter(callable $callback)
 * @method newBlockFilter(callable $callback)
 * @method newPendingTransactionFilter(callable $callback)
 * @method uninstallFilter(callable $callback)
 * @method getFilterChanges(callable $callback)
 * @method getFilterLogs(callable $callback)
 * @method getLogs(callable $callback)
 * @method submitWork(callable $callback)
 * @method submitHashrate(callable $callback)
 */
class Eth
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
        'eth_protocolVersion', 'eth_syncing', 'eth_coinbase', 'eth_mining', 'eth_hashrate', 'eth_gasPrice',
        'eth_accounts', 'eth_blockNumber', 'eth_getBalance', 'eth_getStorageAt', 'eth_getTransactionCount',
        'eth_getBlockTransactionCountByHash', 'eth_getBlockTransactionCountByNumber', 'eth_getUncleCountByBlockHash',
        'eth_getUncleCountByBlockNumber', 'eth_getUncleByBlockHashAndIndex', 'eth_getUncleByBlockNumberAndIndex',
        'eth_getCode', 'eth_sign', 'eth_sendTransaction', 'eth_sendRawTransaction', 'eth_call', 'eth_estimateGas',
        'eth_getBlockByHash', 'eth_getBlockByNumber', 'eth_getTransactionByHash', 'eth_getTransactionByBlockHashAndIndex',
        'eth_getTransactionByBlockNumberAndIndex', 'eth_getTransactionReceipt', 'eth_compileSolidity', 'eth_compileLLL',
        'eth_compileSerpent', 'eth_getWork', 'eth_newFilter', 'eth_newBlockFilter', 'eth_newPendingTransactionFilter',
        'eth_uninstallFilter', 'eth_getFilterChanges', 'eth_getFilterLogs', 'eth_getLogs', 'eth_submitWork',
        'eth_submitHashrate',
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
     * Auto detect nonce and send offline transaction to network.
     *
     * @throws Exception
     */
    public function sendAuto(
        string $privateKey,
        mixed $gasPrice,
        mixed $gasLimit,
        string $to,
        mixed $value,
        int $nonce = 1
    ): string
    {
        $txid = $this->_sendAuto(
            $privateKey,
            $gasPrice,
            $gasLimit,
            $to,
            $value,
            $nonce
        );

        if (is_int($txid)) {
            $txid = $this->_sendAuto(
                $privateKey,
                $gasPrice,
                $gasLimit,
                $to,
                $value,
                $txid
            );
        }

        if (is_int($txid)) {
            throw new Exception('nonce error: ' . $txid);
        }

        return $txid;
    }

    /**
     * @param string $privateKey
     * @param mixed $gasPrice
     * @param mixed $gasLimit
     * @param string $to
     * @param mixed $value
     * @param int $nonce
     *
     * @return string|int|mixed
     * @throws Exception
     */
    private function _sendAuto(
        string $privateKey,
        mixed $gasPrice,
        mixed $gasLimit,
        string $to,
        mixed $value,
        int $nonce = 1
    ): mixed
    {
        $self    = &$this;
        $txid    = '';
        $txError = null;

        $tx    = new Transaction($nonce, $gasPrice, $gasLimit, $to, $value);
        $rawTx = '0x' . $tx->getRaw($privateKey);

        $self->sendRawTransaction(
            $rawTx,
            function ($err, $ethData) use (&$self, &$txid, &$txError) {
                if ($err) {
                    $errorMessage = (string)$err->getMessage();

                    // Check nonce error. Example nonce exception string:
                    // the tx doesn't have the correct nonce. account has nonce of: 8 tx has nonce of: 1
                    if (strpos($errorMessage, 'have the correct nonce') !== false) {
                        $lastNonce    = (int)trim(explode(': ', $errorMessage)[0]);
                        $correctNonce = $lastNonce + 1;
                        $txid         = $correctNonce;
                    } else {
                        $txError = (string)$err->getMessage();
                    }

                    return;
                }
                $txid = $ethData;
            }
        );

        if (!is_null($txError)) {
            throw new Exception($txError);
        }

        return $txid;
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
