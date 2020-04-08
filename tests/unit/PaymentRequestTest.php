<?php

namespace unit;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Sepia\Redsys\PaymentRequest;
use Sepia\Redsys\PaymentRequest\CurrencyCode;
use Sepia\Redsys\PaymentRequest\SiteUrls;
use Sepia\Redsys\PaymentRequest\Parameter;
use Sepia\Redsys\PaymentRequest\PaymentMethod;
use Sepia\Redsys\PaymentRequest\TransactionType;

class PaymentRequestTest extends TestCase
{
    /** @test */
    public function payload_is_properly_generated()
    {
        $paymentRequest = new PaymentRequest(Money::EUR(124.12), '1234', 'merchantCode', PaymentMethod::CARD, TransactionType::AUTHORIZATION, 1, new SiteUrls('http://ecommerce.site/ok', 'http://ecommerce.site/ko'));

        $payloadParameters = $paymentRequest->buildPayloadParameters();

        $expected =[
            Parameter::ORDER => '1234',
            Parameter::AMOUNT => 12412,
            Parameter::CURRENCY => CurrencyCode::EUR,
            Parameter::PAYMENT_METHOD => PaymentMethod::CARD,
            Parameter::TRANSACTION_TYPE => TransactionType::AUTHORIZATION,
            Parameter::MERCHANT_CODE => 'merchantCode',
            Parameter::TERMINAL => 1,
            Parameter::URL_OK => 'http://ecommerce.site/ok',
            Parameter::URL_KO => 'http://ecommerce.site/ko'
        ];

        $this->assertEquals($expected, $payloadParameters);
    }

    }
}
