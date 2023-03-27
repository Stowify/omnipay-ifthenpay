<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay\Enum;

use Omnipay\IfThenPay\Request\CardRequest;
use Omnipay\IfThenPay\Request\MBWayRequest;
use Omnipay\IfThenPay\Request\MultibancoRequest;

enum PayMethod: string
{
    case Card       = 'card';
    case MBWay      = 'mbway';
    case Multibanco = 'multibanco';

    public function defaultParameters(): array
    {
        return match ($this) {
            self::Card => [
                'reference'  => '',
                'amount'     => '',
                'successUrl' => '',
                'errorUrl'   => '',
                'cancelUrl'  => '',
                'language'   => 'en',
            ],
            self::MBWay => [
                'key'         => '', // Required
                'reference'   => '', // Required
                'amount'      => '', // Required
                'description' => '', // Required
                'clientPhone' => '', // Required
                'clientEmail' => '', // Optional
            ],
            self::Multibanco => [
                'key'            => '',   // Required
                'reference'      => '',   // Required
                'amount'         => '',   // Required
                'description'    => '',   // Optional
                'clientPhone'    => '',   // Optional
                'clientEmail'    => '',   // Optional
                'clientId'       => '',   // Optional
                'clientName'     => '',   // Optional
                'clientUsername' => '',   // Optional
                'merchantUrl'    => '',   // Optional
                'expiryDays'     => 0,    // Optional
                'testMode'       => false // Optional
            ],
        };
    }

    public function requestClass(): string
    {
        return match ($this) {
            self::Card       => CardRequest::class,
            self::MBWay      => MBWayRequest::class,
            self::Multibanco => MultibancoRequest::class,
        };
    }
}
