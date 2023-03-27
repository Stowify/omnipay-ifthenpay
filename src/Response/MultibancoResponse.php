<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Response;

use DateTimeImmutable;
use Omnipay\Common\Message\AbstractResponse;

final class MultibancoResponse extends AbstractResponse
{
    private const CODE_SUCCESS = '0';

    /**
     * The amount being charged.
     *
     * @return ?string
     */
    public function getAmount(): ?string
    {
        return $this->data['Amount'];
    }

    /**
     * The Gateway's transaction reference.
     *
     * @return ?string
     */
    public function getTransactionReference(): ?string
    {
        if (! empty($this->data['RequestId'])) {
            return $this->data['RequestId'];
        }

        return null;
    }

    /**
     * The Merchant's transaction reference.
     *
     * @return ?string
     */
    public function getTransactionId(): ?string
    {
        if (! empty($this->data['OrderId'])) {
            return $this->data['OrderId'];
        }

        return null;
    }

    /**
     * Payment gateway response code.
     *
     * @return ?string
     */
    public function getCode(): ?string
    {
        return $this->data['Status'];
    }

    /**
     * Payment gateway response message.
     *
     * @return ?string
     */
    public function getMessage(): ?string
    {
        return $this->data['Message'];
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return $this->getCode() === self::CODE_SUCCESS;
    }

    /**
     * Multibanco payment entity.
     *
     * @return ?string
     */
    public function getEntity(): ?string
    {
        return $this->data['Entity'];
    }

    /**
     * Multibanco payment reference.
     *
     * @return ?string
     */
    public function getReference(): ?string
    {
        return $this->data['Reference'];
    }

    /**
     * Multibanco payment expiry.
     *
     * @return ?DateTimeImmutable
     * @throws \Exception
     */
    public function getExpiry(): ?DateTimeImmutable
    {
        return new DateTimeImmutable(sprintf('%s 23:59:59', $this->data['ExpiryDate']));
    }
}
