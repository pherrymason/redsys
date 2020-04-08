<?php

namespace unit;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Sepia\Redsys\PaymentRequest;
use Sepia\Redsys\PaymentRequest\CurrencyCode;
use Sepia\Redsys\PaymentRequest\Parameter;
use Sepia\Redsys\PaymentRequest\PaymentMethod;
use Sepia\Redsys\PaymentRequest\TransactionType;

class PaymentRequestTest extends TestCase
{
    /** @test */
    public function amount_is_properly_formated()
    {
        $paymentRequest = new PaymentRequest(Money::EUR(124.12), '1234', 'merchantCode', PaymentMethod::CARD, TransactionType::AUTHORIZATION);

        $payloadParameters = $paymentRequest->buildPayloadParameters();

        $expected =[
            Parameter::ORDER => '1234',
            Parameter::AMOUNT => 12412,
            Parameter::CURRENCY => CurrencyCode::EUR,
            Parameter::PAYMENT_METHOD => PaymentMethod::CARD,
            Parameter::MERCHANT_CODE => 'merchantCode'
        ];

        $this->assertEquals($expected, $payloadParameters);
    }
}
