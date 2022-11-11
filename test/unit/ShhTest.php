<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;
use Kdm\Providers\HttpProvider;
use Kdm\RequestManagers\RequestManager;
use Kdm\RequestManagers\HttpRequestManager;
use Kdm\Shh;

class ShhTest extends TestCase
{
    /**
     * shh
     * 
     * @var Kdm\Shh
     */
    protected $shh;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->shh = $this->web3->shh;
    }

    /**
     * testInstance
     * 
     * @return void
     */
    public function testInstance()
    {
        $shh = new Shh($this->testHost);

        $this->assertTrue($shh->provider instanceof HttpProvider);
        $this->assertTrue($shh->provider->requestManager instanceof RequestManager);
    }

    /**
     * testSetProvider
     * 
     * @return void
     */
    public function testSetProvider()
    {
        $shh = $this->shh;
        $requestManager = new HttpRequestManager('http://localhost:8545');
        $shh->provider = new HttpProvider($requestManager);

        $this->assertEquals($shh->provider->requestManager->host, 'http://localhost:8545');

        $shh->provider = null;

        $this->assertEquals($shh->provider->requestManager->host, 'http://localhost:8545');
    }

    /**
     * testCallThrowRuntimeException
     * 
     * @return void
     */
    public function testCallThrowRuntimeException()
    {
        $this->expectException(RuntimeException::class);

        $shh = new Shh(null);
        $shh->post([]);
    }
}
