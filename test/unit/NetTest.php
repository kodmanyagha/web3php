<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Kdm\Providers\HttpProvider;
use Kdm\RequestManagers\RequestManager;
use Kdm\RequestManagers\HttpRequestManager;
use Kdm\Net;

class NetTest extends TestCase
{
    /**
     * net
     * 
     * @var Kdm\Net
     */
    protected $net;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->net = $this->web3->net;
    }

    /**
     * testInstance
     * 
     * @return void
     */
    public function testInstance()
    {
        $net = new Net($this->testHost);

        $this->assertTrue($net->provider instanceof HttpProvider);
        $this->assertTrue($net->provider->requestManager instanceof RequestManager);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {
        $net = $this->net;
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $net->provider = new HttpProvider($requestManager);

        $this->assertEquals($net->provider->requestManager->host, 'http://localhost:8545');

        $net->provider = null;

        $this->assertEquals($net->provider->requestManager->host, 'http://localhost:8545');
    }

    /**
     * testCallThrowRuntimeException
     * 
     * @return void
     */
    public function testCallThrowRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        $net = new Net(null);
        $net->version();
    }
}
