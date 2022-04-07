<?php declare(strict_types=1);

namespace Omnipay\Utrust\Tests\Message\Request;

use GuzzleHttp\Psr7\Request;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Item;
use Omnipay\Common\ItemBag;
use Omnipay\Tests\TestCase;
use Omnipay\Utrust\Message\Request\PurchaseRequest;
use Omnipay\Utrust\Message\Response\PurchaseResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class PurchaseRequestTest extends TestCase
{
    private PurchaseRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setApiKey('u_test_api-92a6af14-f5fc-4aee-9bbd-37b8a6fee615');
    }

    public function testGetData(): void
    {
        $card = new CreditCard($this->getValidCard());
        $card->setEmail('test@example.com');

        $this->request->setCard($card);
        $this->request->setTransactionReference('ORDER-10001');
        $this->request->setAmount(50);
        $this->request->setCurrency('USD');
        $this->request->setReturnUrl('https://foo.bar/return-url');
        $this->request->setCancelUrl('https://foo.bar/cancel-url');
        $this->request->setNotifyUrl('https://foo.bar/notify-url');
        $this->request->setItems(new ItemBag([
            new Item([
                'name' => 'Test item',
                'price' => 50.00,
                'currency' => 'USD',
                'quantity' => 1,
            ])
        ]));

        $expectedData = [
            'data' => [
                'type' => 'orders',
                'attributes' => [
                    'order' => [
                        'reference' => 'ORDER-10001',
                        'amount' => [
                            'total' => 50,
                            'currency' => 'USD',
                        ],
                        'return_urls' => [
                            'return_url' => 'https://foo.bar/return-url',
                            'cancel_url' => 'https://foo.bar/cancel-url',
                            'callback_url' => 'https://foo.bar/notify-url',
                        ],
                        'line_items' => [
                            [
                                'name' => 'Test item',
                                'price' => 50.00,
                                'currency' => 'USD',
                                'quantity' => 1,
                            ],
                        ],
                    ],
                    'customer' => [
                        'first_name' => 'Example',
                        'last_name' => 'User',
                        'email' => 'test@example.com',
                        'country' => 'US',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedData, $this->request->getData());
    }

    public function testSendData(): void
    {
        $data = [
            'data' => [
                'type' => 'orders',
                'attributes' => [
                    'order' => [
                        'reference' => 'ORDER-10001',
                        'amount' => [
                            'total' => 50,
                            'currency' => 'USD',
                        ],
                        'return_urls' => [
                            'return_url' => 'https://foo.bar/return-url',
                            'cancel_url' => 'https://foo.bar/cancel-url',
                            'callback_url' => 'https://foo.bar/notify-url',
                        ],
                        'line_items' => [
                            [
                                'name' => 'Test item',
                                'price' => 50.00,
                                'currency' => 'USD',
                                'quantity' => 1,
                            ],
                        ],
                    ],
                    'customer' => [
                        'first_name' => 'Example',
                        'last_name' => 'User',
                        'email' => 'test@example.com',
                        'country' => 'US',
                    ],
                ],
            ],
        ];

        $response = $this->request->sendData($data);

        $this->assertInstanceOf(PurchaseResponse::class, $response);

        $expectedRequest = new Request(
            SymfonyRequest::METHOD_POST,
            'https://merchants.api.utrust.com/api/stores/orders'
        );

        $this->assertEquals($expectedRequest->getMethod(), $this->getMockClient()->getLastRequest()->getMethod());
        $this->assertEquals($expectedRequest->getUri(), $this->getMockClient()->getLastRequest()->getUri());
    }
}
