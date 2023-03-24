<?php

declare(strict_types=1);

namespace Omnipay\IfThenPay;

enum PayMethod: string
{
    case MBWay      = 'mbway';
    case Multibanco = 'multibanco';

    public function defaultParameters(): array
    {
        return match ($this) {
            self::MBWay => [
                'key'         => '', // Required
                'reference'   => '', // Required
                'amount'      => '', // Required
                'description' => '', // Required
                'clientPhone' => '', // Required
                'clientEmail' => '', // Optional
            ],
            self::Multibanco => [
                'key'            => '', // Required
                'reference'      => '', // Required
                'amount'         => '', // Required
                'description'    => '', // Optional
                'clientPhone'    => '', // Optional
                'clientEmail'    => '', // Optional
                'clientId'       => '', // Optional
                'clientName'     => '', // Optional
                'clientUsername' => '', // Optional
                'url'            => '', // Optional
                'expiryDays'     => 0,  // Optional
            ],
        };
    }
}
