# web3.php

[![PHP](https://github.com/kodmanyagha/web3php/actions/workflows/php.yml/badge.svg)](https://github.com/web3p/web3.php/actions/workflows/php.yml)
[![Build Status](https://travis-ci.org/kodmanyagha/web3php.svg?branch=master)](https://travis-ci.org/kodmanyagha/web3php)
[![codecov](https://codecov.io/gh/kodmanyagha/web3php/branch/master/graph/badge.svg)](https://codecov.io/gh/web3p/web3.php)
[![Join the chat at https://gitter.im/web3-php/web3.php](https://img.shields.io/badge/gitter-join%20chat-brightgreen.svg)](https://gitter.im/kodmanyagha/web3php)
[![Licensed under the MIT License](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/kodmanyagha/web3php/blob/master/LICENSE)


A php interface for interacting with the Ethereum blockchain and ecosystem.

# Install

Set minimum stability to dev
```
"minimum-stability": "dev"
```

Then
```
composer require kodmanyagha/web3php dev-master
```

Or you can add this line in composer.json

```
"kodmanyagha/web3php": "dev-master"
```


# Usage

### New instance
```php
use Kdm\Web3;

$web3 = new Web3('http://localhost:8545');
```

### Using provider
```php
use Kdm\Web3;
use Kdm\Providers\HttpProvider;
use Kdm\RequestManagers\HttpRequestManager;

$web3 = new Web3(new HttpProvider(new HttpRequestManager('http://localhost:8545')));

// timeout
$web3 = new Web3(new HttpProvider(new HttpRequestManager('http://localhost:8545', 0.1)));
```

### You can use callback to each rpc call:
```php
$web3->clientVersion(function ($err, $version) {
    if ($err !== null) {
        // do something
        return;
    }
    if (isset($version)) {
        echo 'Client version: ' . $version;
    }
});
```

### Eth
```php
use Kdm\Web3;

$web3 = new Web3('http://localhost:8545');
$eth = $web3->eth;
```

Or

```php
use Kdm\Eth;

$eth = new Eth('http://localhost:8545');
```

### Net
```php
use Kdm\Web3;

$web3 = new Web3('http://localhost:8545');
$net = $web3->net;
```

Or

```php
use Kdm\Net;

$net = new Net('http://localhost:8545');
```

### Batch

web3
```php
$web3->batch(true);
$web3->clientVersion();
$web3->hash('0x1234');
$web3->execute(function ($err, $data) {
    if ($err !== null) {
        // do something
        // it may throw exception or array of exception depends on error type
        // connection error: throw exception
        // json rpc error: array of exception
        return;
    }
    // do something
});
```

eth

```php
$eth->batch(true);
$eth->protocolVersion();
$eth->syncing();

$eth->provider->execute(function ($err, $data) {
    if ($err !== null) {
        // do something
        return;
    }
    // do something
});
```

net
```php
$net->batch(true);
$net->version();
$net->listening();

$net->provider->execute(function ($err, $data) {
    if ($err !== null) {
        // do something
        return;
    }
    // do something
});
```

personal
```php
$personal->batch(true);
$personal->listAccounts();
$personal->newAccount('123456');

$personal->provider->execute(function ($err, $data) {
    if ($err !== null) {
        // do something
        return;
    }
    // do something
});
```

### Contract

```php
use Kdm\Contract;

$contract = new Contract('http://localhost:8545', $abi);

// deploy contract
$contract->bytecode($bytecode)->new($params, $callback);

// call contract function
$contract->at($contractAddress)->call($functionName, $params, $callback);

// change function state
$contract->at($contractAddress)->send($functionName, $params, $callback);

// estimate deploy contract gas
$contract->bytecode($bytecode)->estimateGas($params, $callback);

// estimate function gas
$contract->at($contractAddress)->estimateGas($functionName, $params, $callback);

// get constructor data
$constructorData = $contract->bytecode($bytecode)->getData($params);

// get function data
$functionData = $contract->at($contractAddress)->getData($functionName, $params);
```

# Assign value to outside scope(from callback scope to outside scope)
Due to callback is not like javascript callback, 
if we need to assign value to outside scope, 
we need to assign reference to callback.
```php
$newAccount = '';

$web3->personal->newAccount('123456', function ($err, $account) use (&$newAccount) {
    if ($err !== null) {
        echo 'Error: ' . $err->getMessage();
        return;
    }
    $newAccount = $account;
    echo 'New account: ' . $account . PHP_EOL;
});
```

# Examples

To run examples, you need to run ethereum blockchain local (testrpc).

If you are using docker as development machain, you can try [ethdock](https://github.com/sc0vu/ethdock) to run local ethereum blockchain, just simply run `docker-compose up -d testrpc` and expose the `8545` port.

# Develop

### Local php cli installed

1. Clone the repo and install packages.
```
git clone https://github.com/web3p/web3.php.git && cd web3.php && composer install
```

2. Run test script.
```
vendor/bin/phpunit
```

### Docker container

1. Clone the repo and run docker container.
```
git clone https://github.com/web3p/web3.php.git
```

2. Copy web3php to web3php/docker/app directory and start container.
```
cp files docker/app && docker-compose up -d php ganache
```

3. Enter php container and install packages.
```
docker-compose exec php ash
```

4. Change testHost in `TestCase.php`
```
/**
 * testHost
 * 
 * @var string
 */
protected $testHost = 'http://ganache:8545';
```

5. Run test script
```
vendor/bin/phpunit
```

###### Install packages
Enter container first
```
docker-compose exec php ash
```

1. gmp
```
apk add gmp-dev
docker-php-ext-install gmp
```

2. bcmath
```
docker-php-ext-install bcmath
```

3openssl
```
docker-php-ext-install openssl
```

###### Remove extension
Move the extension config from `/usr/local/etc/php/conf.d/`
```
mv /usr/local/etc/php/conf.d/extension-config-name to/directory
```


# License
MIT
