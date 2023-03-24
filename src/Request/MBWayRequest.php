<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Request;

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
    private const MEDIA_TYPE = 'application/x-www-form-urlencoded';

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
            $this->buildURL(self::BASE_URL, 'ifthenpaymbw.asmx/SetPedidoJSON'),
            $headers,
            http_build_query($data),
        );

        return new MBWayResponse($this, json_decode($response->getBody()->getContents(), true));
    }
}
