<?php

namespace Sepia\Redsys;

use Money\Money;
use Sepia\Redsys\PaymentRequest\CurrencyCode;
use Sepia\Redsys\PaymentRequest\SiteUrls;
use Sepia\Redsys\PaymentRequest\Parameter;
use Sepia\Redsys\PaymentRequest\PaymentMethod;
use Sepia\Redsys\PaymentRequest\TransactionType;

final class PaymentRequest
{
    /** @var Money */
    private $amount;
    /** @var string */
    private $orderNumber;
    /** @var string */
    private $merchantCode;
    /** @var string */
    private $merchantData;
    /** @var PaymentMethod */
    private $paymentMethod;
    /** @var TransactionType */
    private $transactionType;
    /** @var int */
    private $terminal;
    /** @var SiteUrls */
    private $flowUrl;
    /** @var string */
    private $notificationUrl;

    public function __construct(Money $amount, string $orderNumber, string $merchantCode, $paymentMethod, $transactionType, $terminal, SiteUrls $flowUrl)
    {
        $this->amount = $amount;
        $this->orderNumber = $orderNumber;
        $this->merchantCode = $merchantCode;
        $this->paymentMethod = $paymentMethod;
        $this->transactionType = $transactionType;
        $this->terminal = $terminal;
        $this->flowUrl = $flowUrl;
    }

    public function buildPayloadParameters(): array
    {
        $parameters = [
            Parameter::ORDER => $this->orderNumber,
            Parameter::MERCHANT_CODE => $this->merchantCode,
            Parameter::AMOUNT => $this->formatAmount($this->amount),
            Parameter::CURRENCY => CurrencyCode::convertFromCurrency($this->amount->currency()),
            Parameter::PAYMENT_METHOD => $this->paymentMethod,
            Parameter::TRANSACTION_TYPE => $this->transactionType,
            Parameter::TERMINAL => $this->terminal,
            Parameter::URL_OK => $this->flowUrl->okUrl(),
            Parameter::URL_KO => $this->flowUrl->koUrl()
        ];

        if ($this->flowUrl->notificationUrl() !== null){
            $parameters[Parameter::NOTIFICATION_URL] = $this->flowUrl->notificationUrl();
        }

        if ($this->merchantData !== null) {
            $parameters[Parameter::MERCHANT_DATA] = $this->merchantData;
        }

        return $parameters;
    }

    private function formatAmount(Money $amount): int
    {
        $plainAmount = $amount->round(2)->amount();
        $plainAmount = number_format(str_replace(',', '.', $plainAmount), 2, '.', '');

        return (int)(string)($plainAmount * 100);
    }

    public function setMerchantData(string $merchantData): void
    {
        $this->merchantData = $merchantData;
    }
}
