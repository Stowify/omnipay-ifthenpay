<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Request;

use LengthException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\IfThenPay\Response\MultibancoResponse;
use RangeException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @link https://helpdesk.ifthenpay.com/en/support/solutions/articles/79000128866-api-request-multibanco-references
 */
class MultibancoRequest extends AbstractRequest
{
    private const BASE_URL   = 'https://ifthenpay.com';
    private const MEDIA_TYPE = 'application/json';

    /**
     * @param  string  $value
     * @return self
     */
    public function setReference(string $value): self
    {
        if (mb_strlen($value) > 25) {
            throw new LengthException('The reference value must not exceed 25 characters');
        }

        return $this->setParameter('reference', $value);
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setDescription($value): self
    {
        if (mb_strlen($value) > 200) {
            throw new LengthException('The description value must not exceed 200 characters');
        }

        return $this->setParameter('description', $value);
    }

    /**
     * @return ?string
     */
    public function getClientId(): ?string
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientId(string $value): self
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return ?string
     */
    public function getClientName(): ?string
    {
        return $this->getParameter('clientName');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientName(string $value): self
    {
        return $this->setParameter('clientName', $value);
    }

    /**
     * @return ?string
     */
    public function getClientUsername(): ?string
    {
        return $this->getParameter('clientUsername');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientUsername(string $value): self
    {
        return $this->setParameter('clientUsername', $value);
    }

    /**
     * @return ?string
     */
    public function getMerchantUrl(): ?string
    {
        return $this->getParameter('merchantUrl');
    }

    /**
     * @param  int  $value
     * @return self
     */
    public function setExpiryDays(int $value): self
    {
        if ($value < 0 || $value > 730) {
            throw new RangeException('The expiry days value must be between 0 and 730');
        }

        return $this->setParameter('expiryDays', $value);
    }

    /**
     * @return ?int
     */
    public function getExpiryDays(): ?int
    {
        return $this->getParameter('expiryDays');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setMerchantUrl(string $value): self
    {
        return $this->setParameter('merchantUrl', $value);
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        // Required properties
        $this->validate(
            'key',
            'reference',
            'amount',
        );

        return [
            'mbKey'          => $this->getKey(),
            'orderId'        => $this->getReference(),
            'amount'         => $this->getAmount(),
            'description'    => $this->getDescription(),
            'url'            => $this->getMerchantUrl(),
            'clientCode'     => $this->getClientId(),
            'clientName'     => $this->getClientName(),
            'clientEmail'    => $this->getClientEmail(),
            'clientUsername' => $this->getClientUsername(),
            'clientPhone'    => $this->getClientPhone(),
            'expiryDays'     => $this->getExpiryDays(),
        ];
    }

    /**
     * @param  mixed  $data
     * @return MultibancoResponse
     */
    public function sendData($data): MultibancoResponse
    {
        $headers = [
            'Content-Type' => self::MEDIA_TYPE,
        ];

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            $this->buildURL(self::BASE_URL, 'api/multibanco/reference', $this->getTestMode() ? 'sandbox' : 'init'),
            $headers,
            json_encode($data),
        );

        return new MultibancoResponse($this, json_decode($response->getBody()->getContents(), true));
    }
}
