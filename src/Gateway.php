<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\IfThenPay\Enum\PayMethod;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Gateway extends AbstractGateway
{
    protected PayMethod $payMethod;

    /**
     * @param  PayMethod  $payMethod
     * @param  ?ClientInterface  $httpClient
     * @param  ?SymfonyRequest  $httpRequest
     */
    public function __construct(PayMethod $payMethod, ClientInterface $httpClient = null, SymfonyRequest $httpRequest = null)
    {
        $this->payMethod = $payMethod;

        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * The gateway display name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'IfThenPay';
    }

    /**
     * Get the default parameters of the gateway channel.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return $this->payMethod->defaultParameters();
    }

    public function purchase(array $options = []): RequestInterface
    {
        return $this->createRequest($this->payMethod->requestClass(), $options);
    }
}
