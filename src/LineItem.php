<?php declare(strict_types=1);

namespace Omnipay\Utrust;

use Omnipay\Common\Item;
use Omnipay\Common\ItemInterface;

class LineItem extends Item
{
    public function getCurrency(): string
    {
        return $this->getParameter('currency');
    }

    public function setCurrency($value): void
    {
        $this->setParameter('currency', $value);
    }

    public static function fromItem(ItemInterface $item, string $currency): self
    {
        $parameters = $item->getParameters();
        $parameters['currency'] = $currency;

        return new self($parameters);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'price' => number_format($this->getPrice(), 2),
            'currency' => $this->getCurrency(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
