<?php

namespace App\Core\Helper;

class StringHelper {
    public static function generateRandomToken(int $tokenLength=16, string $hashAlgo="sha256"): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $tokenLength; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return hash($hashAlgo, $randomString);
    }
}