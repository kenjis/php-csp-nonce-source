<?php
/**
 * CSP
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/php-csp-nonce-source
 */

class Csp
{
    private static $nonce;

    private static function generateNonce()
    {
        $length = 16;

        $bytes = '';
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $usable);
            if ($usable === false) {
                // weak
            }
        } else {
            throw new Exception('Can\'t use openssl_random_pseudo_bytes');
        }

        static::$nonce = base64_encode($bytes);
    }

    public static function setHeader()
    {
        if (static::$nonce === null) {
            static::generateNonce();
        }

        header("Content-Security-Policy: unsafe-inline; script-src 'nonce-" . static::$nonce . "'");
    }

    public static function getNonce()
    {
        if (static::$nonce === null) {
            static::generateNonce();
        }

        return static::$nonce;
    }
}
