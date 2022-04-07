<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Utrust\LineItem;
use Omnipay\Utrust\Message\Response\PurchaseResponse;

class PurchaseRequest extends AbstractRequest
{
    public function getData(): array
    {
        $card = $this->getCard();
        $this->guardBillingCountry($card->getBillingCountry());

        return [
            'data' => [
                'type' => 'orders',
                'attributes' => [
                    'order' => [
                        'reference' => $this->getTransactionReference(),
                        'amount' => [
                            'total' => $this->getAmount(),
                            'currency' => $this->getCurrency(),
                        ],
                        'return_urls' => [
                            'return_url' => $this->getReturnUrl(),
                            'cancel_url' => $this->getCancelUrl(),
                            'callback_url' => $this->getNotifyUrl(),
                        ],
                        'line_items' => $this->createLineItems(),
                    ],
                    'customer' => [
                        'first_name' => $card->getFirstName(),
                        'last_name' => $card->getLastName(),
                        'email' => $card->getEmail(),
                        'country' => $card->getBillingCountry(),
                    ],
                ],
            ],
        ];
    }

    protected function getPath(): ?string
    {
        return 'stores/orders';
    }

    protected function getResponseClass(): string
    {
        return PurchaseResponse::class;
    }

    private function createLineItems(): array
    {
        $items = [];

        foreach ($this->getItems() as $item) {
            $items[] = LineItem::fromItem($item, $this->getCurrency())->toArray();
        }

        return $items;
    }

    private function guardBillingCountry(string $billingCountry): void
    {
        if (!preg_match('/^[a-zA-Z]{2}$/', $billingCountry)) {
            throw new InvalidRequestException(
                sprintf('Billing country "%s" must be an ISO-3166 two-digit code.', $billingCountry)
            );
        }
    }
}
