<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message\Request;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData(): array
    {
        return [];
    }

    protected function getPath(): ?string
    {
        return null;
    }

    protected function getResponseClass(): string
    {
        return '';
    }
}
