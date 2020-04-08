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
    public function payload_is_properly_generated()
    {
        $paymentRequest = new PaymentRequest(Money::EUR(124.12), '1234', 'merchantCode', PaymentMethod::CARD, TransactionType::AUTHORIZATION, 1, 'http://ecommerce.site/ok', 'http://ecommerce.site/ko');

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
/*
        $redsys->setNameForm('payment_form');
        $redsys->setAmount($amount);
        $redsys->setOrder($orderCode);
        $redsys->setMerchantcode($this->credentials->code());
        $redsys->setCurrency('978');
        $redsys->setTransactiontype('0');
        $redsys->setTerminal('1');
        $redsys->setMerchantData($cart->getUUID());
        $redsys->setMethod('C'); //Solo pago con tarjeta, no mostramos iupay

        $webHookUrl = CheckoutRouteGenerator::webhook($this->name(), $cart->getUUID(), $paymentRequest->info()->id(), false);

        //Url de notificacion
        $redsys->setNotification($webHookUrl);

        $redsys->setUrlOk(CheckoutRouteGenerator::charge($cart->getUUID(), $paymentRequest->info()->id()));


        $url = CheckoutRouteGenerator::form(2);
        $urlParser = new Parser();
        $urlComponents = $urlParser($url);
        $query = explode('&', $urlComponents['query']);
        $query[] = 'error=1';
        if (!empty($urlComponents['query'])) {
            $url = str_replace('?' . $urlComponents['query'], '?' . implode('&', $query), $url);
        } else {
            $url.= '?' . implode('&', $query);
        }
        $redsys->setUrlKo($url);

        $redsys->setVersion('HMAC_SHA256_V1');
        $redsys->setTradeName($this->credentials->name());
        $redsys->setProductDescription($description);
        $redsys->setEnviroment($this->credentials->environment());
        $signature = $redsys->generateMerchantSignature($this->credentials->key());
        $redsys->setMerchantSignature($signature);
*/
    }
}
