<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message\Response;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return false;
    }
}
