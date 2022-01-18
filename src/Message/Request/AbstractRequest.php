<?php declare(strict_types=1);

namespace Omnipay\Utrust\Message\Request;

use Omnipay\Common\Message\AbstractResponse;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected string $testEndpoint = 'https://merchants.api.sandbox-utrust.com/api/';
    protected string $liveEndpoint = 'https://merchants.api.utrust.com/api/';

    public function getApiKey(): string
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey(string $value): self
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getHttpMethod(): string
    {
        return 'POST';
    }

    public function sendData($data): AbstractResponse
    {
        $response = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndPoint().$this->getPath(),
            $this->getHeaders(),
            json_encode($data)
        );

        $responseBody = json_decode($response->getBody()->getContents(), true);
        $responseClass = $this->getResponseClass();
        return new $responseClass($this, $responseBody);
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getApiKey(),
            'Content-Type' => 'application/json',
        ];
    }

    abstract protected function getPath(): ?string;
    abstract protected function getResponseClass(): string;

    private function getEndPoint(): string
    {
        if ($this->getTestMode() === true) {
            return $this->testEndpoint;
        }

        return $this->liveEndpoint;
    }
}
