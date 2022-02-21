<?php declare(strict_types=1);

namespace Omnipay\Utrust;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Utrust\Message\Request\CompletePurchaseRequest;
use Omnipay\Utrust\Message\Request\PurchaseRequest;

/**
 *  Utrust gateway for Omnipay
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

    public function purchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array()): RequestInterface
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    public function getApiKey(): string
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey(string $value): self
    {
        return $this->setParameter('apiKey', $value);
    }
}
