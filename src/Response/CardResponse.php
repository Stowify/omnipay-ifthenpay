<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Response;

use Omnipay\Common\Message\AbstractResponse;

class CardResponse extends AbstractResponse
{
    private const CODE_SUCCESS = '0';

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
     * Payment gateway redirect URL.
     *
     * @return ?string
     */
    public function getRedirectUrl(): ?string
    {
        return $this->data['PaymentUrl'];
    }

    /**
     * Is the response a redirect?
     *
     * @return boolean
     */
    public function isRedirect(): bool
    {
        return true;
    }
}
