<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message\Response;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful(): bool
    {
        return isset($this->data['data']['id']);
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['data']['id'] ?? null;
    }
}
