<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message\Response;

class PurchaseResponse extends AbstractResponse
{
    public function isRedirect(): bool
    {
        return isset($this->data['data']['attributes']['redirect_url']) ?? false;
    }
}
