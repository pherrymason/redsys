<?php

namespace Sepia\Redsys;

use Money\Money;
use Sepia\Redsys\PaymentRequest\CurrencyCode;
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
    private $terminal;
    /** @var string */
    private $urlOk;
    /** @var string */
    private $urlKo;

    public function __construct(Money $amount, string $orderNumber, string $merchantCode, $paymentMethod, $transactionType, $terminal, string $urlOk, string $urlKo)
    {
        $this->amount = $amount;
        $this->orderNumber = $orderNumber;
        $this->merchantCode = $merchantCode;
        $this->paymentMethod = $paymentMethod;
        $this->transactionType = $transactionType;
        $this->terminal = $terminal;
        $this->urlOk = $urlOk;
        $this->urlKo = $urlKo;
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
            Parameter::URL_OK => $this->urlOk,
            Parameter::URL_KO => $this->urlKo
        ];

        return $parameters;
    }


    private function formatAmount(Money $amount): int
    {
        $plainAmount = $amount->round(2)->amount();
        $plainAmount = number_format(str_replace(',', '.', $plainAmount), 2, '.', '');

        return (int)(string)($plainAmount * 100);
    }
}
