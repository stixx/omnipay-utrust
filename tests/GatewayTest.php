<?php declare(strict_types=1);

namespace Omnipay\Utrust\Tests;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Utrust\Gateway;
use Omnipay\Utrust\Message\Request\CompletePurchaseRequest;
use Omnipay\Utrust\Message\Request\PurchaseRequest;

class GatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase(): void
    {
        $request = $this->gateway->purchase(['apiKey' => 'u_test_api']);

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame('u_test_api', $request->getApiKey());
    }

    public function testCompletePurchase(): void
    {
        $request = $this->gateway->completePurchase(['apiKey' => 'u_test_api']);

        $this->assertInstanceOf(CompletePurchaseRequest::class, $request);
    }
}
