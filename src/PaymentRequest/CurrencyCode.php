<?php

namespace Sepia\Redsys\PaymentRequest;

class CurrencyCode
{
    const EUR = 978;
    const USD = 840;
    const GBP = 826;
    const JPY = 392;

    public static function convertFromCurrency(\Money\Currency $currency): int
    {
        switch ($currency->code()) {
            case 'EUR':
                return self::EUR;

            case 'USD':
                return self::USD;

            case 'GBP':
                return self::GBP;

            case 'JPY':
                return self::JPY;

            default:
                throw new \InvalidArgumentException('Currency code not supported');
        }
    }
}
