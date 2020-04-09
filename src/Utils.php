<?php

namespace Sepia\Redsys;

final class Utils
{
    public static function encrypt_3DES($data, $key): string
    {
        $iv = "\0\0\0\0\0\0\0\0";
        $data_padded = $data;

        if (strlen($data_padded) % 8) {
            $data_padded = str_pad($data_padded,strlen($data_padded) + 8 - strlen($data_padded) % 8, "\0");
        }

        $ciphertext = openssl_encrypt($data_padded, 'DES-EDE3-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);

        return $ciphertext;
    }

    public static function hmac256($data, $key): string
    {
        return hash_hmac('sha256', $data, $key, true);
    }

    public static function base64_url_encode(string $input): string
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    public static function base64_url_decode($input): string
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
