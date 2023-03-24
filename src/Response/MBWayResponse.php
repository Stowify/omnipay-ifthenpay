<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Response;

use DateTimeImmutable;
use Omnipay\Common\Message\AbstractResponse;

class MBWayResponse extends AbstractResponse
{
    /**
     * The Gateway's transaction reference.
     *
     * @return ?string
     */
    public function getTransactionReference(): ?string
    {
        if (! empty($this->data['IdPedido'])) {
            return $this->data['IdPedido'];
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
        return $this->data['Estado'];
    }

    /**
     * Payment gateway response message.
     *
     * @return ?string
     */
    public function getMessage(): ?string
    {
        return $this->data['MsgDescricao'];
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return $this->getCode() === '000';
    }

    /**
     * The operation timestamp.
     *
     * @return ?DateTimeImmutable
     * @throws \Exception
     */
    public function getTimestamp(): ?DateTimeImmutable
    {
        return new DateTimeImmutable($this->data['DataHora']);
    }
}
