<?php

namespace Omnipay\Utrust;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Utrust\Message\CreateTransactionRequest;

/**
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Utrust Payments';
    }

    public function getDefaultParameters(): array
    {
        return [
            'apiKey' => '',
            'testMode' => false,
        ];
    }

    public function authorize(array $parameters = []): RequestInterface
    {
        return $this->createRequest(CreateTransactionRequest::class, $parameters);
    }
}
