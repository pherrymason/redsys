<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Sepia\Redsys\Security;
use Sermepa\Tpv\Tpv;

class SecurityTest extends TestCase
{
    /** @test */
    public function sign_notification_payload()
    {
        $security = new Security($this->secretKey);
        $signedPayload = $security->signNotificationPayload($this->merchantData());

        $expected = [
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => 'eyJEc19EYXRlIjoiMDlcLzA0XC8yMDIwIiwiRHNfSG91ciI6IjA4OjEyIiwiRHNfU2VjdXJlUGF5bWVudCI6IjEiLCJEc19DYXJkX0NvdW50cnkiOiI3MjQiLCJEc19BbW91bnQiOiIxMzk5MDAiLCJEc19DdXJyZW5jeSI6Ijk3OCIsIkRzX09yZGVyIjoiNDk2MTJlaWZnYW96IiwiRHNfTWVyY2hhbnRDb2RlIjoiMzM0NTEwOTU1IiwiRHNfVGVybWluYWwiOiIwMDEiLCJEc19SZXNwb25zZSI6IjAwMDAiLCJEc19NZXJjaGFudERhdGEiOiJiYmY3MDE0Zi00ZDJiLTQyZDItOWIzZS01OTkwNjQwZGQ5NWEiLCJEc19UcmFuc2FjdGlvblR5cGUiOiIwIiwiRHNfQ29uc3VtZXJMYW5ndWFnZSI6IjEiLCJEc19BdXRob3Jpc2F0aW9uQ29kZSI6IjEyOTA5NSIsIkRzX0NhcmRfQnJhbmQiOiIxIn0=',
            'Ds_Signature' => '3ipAi4RttNRtbSxcIj8FdNguzSFsiWmeFB0WHZK4ds8='
        ];
        $this->assertEquals($expected, $signedPayload);
    }

    /** @test */
    public function merchant_parameters_are_decoded_and_validated()
    {
        $payload = [
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => 'eyJEc19EYXRlIjoiMDlcLzA0XC8yMDIwIiwiRHNfSG91ciI6IjA4OjEyIiwiRHNfU2VjdXJlUGF5bWVudCI6IjEiLCJEc19DYXJkX0NvdW50cnkiOiI3MjQiLCJEc19BbW91bnQiOiIxMzk5MDAiLCJEc19DdXJyZW5jeSI6Ijk3OCIsIkRzX09yZGVyIjoiNDk2MTJlaWZnYW96IiwiRHNfTWVyY2hhbnRDb2RlIjoiMzM0NTEwOTU1IiwiRHNfVGVybWluYWwiOiIwMDEiLCJEc19SZXNwb25zZSI6IjAwMDAiLCJEc19NZXJjaGFudERhdGEiOiJiYmY3MDE0Zi00ZDJiLTQyZDItOWIzZS01OTkwNjQwZGQ5NWEiLCJEc19UcmFuc2FjdGlvblR5cGUiOiIwIiwiRHNfQ29uc3VtZXJMYW5ndWFnZSI6IjEiLCJEc19BdXRob3Jpc2F0aW9uQ29kZSI6IjEyOTA5NSIsIkRzX0NhcmRfQnJhbmQiOiIxIn0=',
            'Ds_Signature' => '3ipAi4RttNRtbSxcIj8FdNguzSFsiWmeFB0WHZK4ds8='
        ];

        $security = new Security($this->secretKey);
        $decoded = $security->validateRedsysRequest($payload);

        $expected = [
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_MerchantParameters' => $this->merchantData(),
            'Ds_Signature' => '3ipAi4RttNRtbSxcIj8FdNguzSFsiWmeFB0WHZK4ds8='
        ];
        $this->assertEquals(
            $expected, $decoded);
    }

    private function merchantData(): array
    {
        return [
            'Ds_Date' => '09/04/2020',
            'Ds_Hour' => '08:12',
            'Ds_SecurePayment' => '1',
            'Ds_Card_Country' => '724',
            'Ds_Amount' => '139900',
            'Ds_Currency' => '978',
            'Ds_Order' => '49612eifgaoz',
            'Ds_MerchantCode' => '334510955',
            'Ds_Terminal' => '001',
            'Ds_Response' => '0000',
            'Ds_MerchantData' => 'bbf7014f-4d2b-42d2-9b3e-5990640dd95a',
            'Ds_TransactionType' => '0',
            'Ds_ConsumerLanguage' => '1',
            'Ds_AuthorisationCode' => '129095',
            'Ds_Card_Brand' => '1'
        ];
    }

    /** @var string  */
    private $secretKey;
    protected function setUp(): void
    {
        parent::setUp();

        $this->secretKey = 'mamamamaa';
    }
}
