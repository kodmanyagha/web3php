<?php

namespace Test\Unit;

use Test\TestCase;
use Kdm\RequestManagers\RequestManager;
use Kdm\Providers\Provider;

class ProviderTest extends TestCase
{
    /**
     * testSetRequestManager
     * 
     * @return void
     */
    public function testSetRequestManager()
    {
        $requestManager = new RequestManager('http://localhost:8545');
        $provider = new Provider($requestManager);

        $this->assertEquals($provider->requestManager->host, 'http://localhost:8545');

        $requestManager = new RequestManager($this->testRinkebyHost);
        $provider->requestManager = $requestManager;

        $this->assertEquals($provider->requestManager->host, 'http://localhost:8545');
    }
}
