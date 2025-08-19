<?php

namespace App\Helpers;

class AesHelper
{
    private static function key(): string
    {
        $key = env('AES_SECRET_KEY');
        return substr(hash('sha256', $key, true), 0, 32);
    }

    private static function b64urlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function b64urlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function encryptId(int|string $id): string
    {
        $payload = json_encode([
            'id' => (string) $id,
            'rand' => bin2hex(random_bytes(5)),
            'time' => time()
        ]);

        $ivLen = openssl_cipher_iv_length('AES-256-CBC');
        $iv = random_bytes($ivLen);

        $cipherText = openssl_encrypt(
            $payload,
            'AES-256-CBC',
            self::key(),
            OPENSSL_RAW_DATA,
            $iv
        );

        return self::b64urlEncode($iv . $cipherText);
    }

    public static function decryptId(string $hash): ?string
    {
        $data = self::b64urlDecode($hash);

        $ivLen = openssl_cipher_iv_length('AES-256-CBC');
        $iv = substr($data, 0, $ivLen);
        $cipherText = substr($data, $ivLen);

        $payload = openssl_decrypt(
            $cipherText,
            'AES-256-CBC',
            self::key(),
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($payload === false) {
            return null;
        }

        $json = json_decode($payload, true);
        return $json['id'] ?? null;
    }
}
