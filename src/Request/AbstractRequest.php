<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Request;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $zeroAmountAllowed = false;

    /**
     * @return ?string
     */
    public function getKey(): ?string
    {
        return $this->getParameter('key');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setKey(string $value): self
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @return ?string
     */
    public function getReference(): ?string
    {
        return $this->getParameter('reference');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setReference(string $value): self
    {
        return $this->setParameter('reference', $value);
    }

    /**
     * @return ?string
     */
    public function getClientPhone(): ?string
    {
        return $this->getParameter('clientPhone');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientPhone(string $value): self
    {
        return $this->setParameter('clientPhone', $value);
    }

    /**
     * @return ?string
     */
    public function getClientEmail(): ?string
    {
        return $this->getParameter('clientEmail');
    }

    /**
     * @param  string  $value
     * @return self
     */
    public function setClientEmail(string $value): self
    {
        return $this->setParameter('clientEmail', $value);
    }

    /**
     * @param  string  $baseURL
     * @param  string  ...$path
     * @return string
     */
    protected function buildURL(string $baseURL, mixed ...$path): string
    {
        return sprintf('%s/%s', $baseURL, implode('/', $path));
    }
}
