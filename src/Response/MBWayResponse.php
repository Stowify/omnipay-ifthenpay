<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Response;

use DateTime;
use Omnipay\Common\Message\AbstractResponse;

/**
 * @link https://helpdesk.ifthenpay.com/en/support/solutions/articles/79000086376-api-mbway
 */
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
     * @return ?DateTime
     * @throws \Exception
     */
    public function getTimestamp(): ?DateTime
    {
        return new DateTime($this->data['DataHora']);
    }
}
