<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Request;

use LengthException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\IfThenPay\Response\MBWayResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @link https://helpdesk.ifthenpay.com/en/support/solutions/articles/79000086376-api-mbway
 */
class MBWayRequest extends AbstractRequest
{
    private const CHANNEL    = '03';
    private const BASE_URL   = 'https://mbway.ifthenpay.com';
    private const ENDPOINT   = 'ifthenpaymbw.asmx/SetPedidoJSON';
    private const MEDIA_TYPE = 'application/x-www-form-urlencoded';

    /**
     * @param  string  $value
     * @return self
     */
    public function setReference(string $value): self
    {
        if (mb_strlen($value) > 15) {
            throw new LengthException('The reference value must not exceed 15 characters');
        }

        return $this->setParameter('reference', $value);
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setDescription($value): self
    {
        if (mb_strlen($value) > 50) {
            throw new LengthException('The description value must not exceed 50 characters');
        }

        return $this->setParameter('description', $value);
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
            'description',
            'clientPhone',
        );

        return [
            'canal'      => self::CHANNEL,
            'MbWayKey'   => $this->getKey(),
            'referencia' => $this->getReference(),
            'valor'      => $this->getAmount(),
            'descricao'  => $this->getDescription(),
            'nrtlm'      => $this->getClientPhone(),
            'email'      => $this->getClientEmail(),
        ];
    }

    /**
     * @param  mixed  $data
     * @return MBWayResponse
     */
    public function sendData($data): MBWayResponse
    {
        $headers = [
            'Content-Type' => self::MEDIA_TYPE,
        ];

        $response = $this->httpClient->request(
            Request::METHOD_POST,
            $this->buildURL(self::BASE_URL, self::ENDPOINT),
            $headers,
            http_build_query($data),
        );

        return new MBWayResponse($this, json_decode($response->getBody()->getContents(), true));
    }
}
