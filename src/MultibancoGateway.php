<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay;

use Omnipay\Common\Http\ClientInterface;
use Omnipay\IfThenPay\Enum\PayMethod;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

final class MultibancoGateway extends CommonGateway
{
    /**
     * @param  ?ClientInterface  $httpClient
     * @param  ?SymfonyRequest  $httpRequest
     */
    public function __construct(ClientInterface $httpClient = null, SymfonyRequest $httpRequest = null)
    {
        parent::__construct(PayMethod::Multibanco, $httpClient, $httpRequest);
    }
}
