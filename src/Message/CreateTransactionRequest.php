<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\ItemInterface;

class CreateTransactionRequest extends AbstractRequest
{
    public function getData(): array
    {
        $card = $this->getCard();

        if (!preg_match('/^[A-Z]{2}$/', $card->getBillingCountry())) {
            throw new InvalidRequestException(
                'Billing country must be an ISO-3166 two-digit code.'
            );
        }

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
                        'line_items' => [
                            $this->createLineItems(),
                        ],
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
        // TODO: Implement getResponseClass() method.
    }

    private function createLineItems(): array
    {
        $items = [];

        /** @var ItemInterface $item */
        foreach ($this->getItems() as $item) {
            $items[] = [
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'currency' => $this->getCurrency(),
                'quantity' => $item->getQuantity(),
            ];
        }

        return $items;
    }
}
