<?php

namespace Sepia\Redsys;

final class Security
{
    /** @var string */
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Useful to generate fake notifications with your own payload.
     * Not to be used in production.
     */
    public function signNotificationPayload(array $payload): array
    {
        $json = json_encode($payload);
        $encoded = Utils::base64_url_encode($json);

        return [
            'Ds_SignatureVersion' => 'HMAC_SHA256_V1',
            'Ds_Signature' => $this->getSignatureFromMerchantParameters($this->secretKey, $payload['Ds_Order'], $encoded),
            'Ds_MerchantParameters' => $encoded
        ];
    }

    /**
     * Validates a Redsys request (both redirect and notification).
     */
    public function validateRedsysRequest(array $payload): array
    {
        $version = $payload['Ds_SignatureVersion'] ?? null;
        $encodedMerchantParameters = $payload['Ds_MerchantParameters'] ?? null;
        $signatureReceived = $payload['Ds_Signature'] ?? null;

        if ($version === null || $encodedMerchantParameters === null || $signatureReceived === null) {
            throw new \InvalidArgumentException('Missing mandatory field');
        }

        $merchantParameters = $this->decodeParameters($encodedMerchantParameters);
        $calculatedSignature = $this->getSignatureFromMerchantParameters(
            $this->secretKey,
            $merchantParameters['Ds_Order'],
            $encodedMerchantParameters
        );

        if ($calculatedSignature !== $signatureReceived) {
            throw new \RuntimeException('Invalid signature received');
        }

        return [
            'Ds_SignatureVersion' => $version,
            'Ds_Signature' => $signatureReceived,
            'Ds_MerchantParameters' => $merchantParameters
        ];
    }

    private function getSignatureFromMerchantParameters(string $secretKey, string $order, $encoded): string
    {
        $secretKey = base64_decode($secretKey);
        $key = Utils::encrypt_3DES($order, $secretKey);

        $result = Utils::hmac256($encoded, $key);

        return Utils::base64_url_encode($result);
    }

    private function decodeParameters(string $encodedPayload): array
    {
        $json = base64_decode(strtr($encodedPayload, '-_', '+/'));

        $decoded = json_decode($json, true, 512);

        if ($decoded === null) {
            if (($jsonError = json_last_error()) !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Could not decode json:' . $jsonError);
            }
        }

        return $decoded;
    }
}
