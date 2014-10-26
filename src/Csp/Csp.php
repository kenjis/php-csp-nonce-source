<?php
/**
 * CSP
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/php-csp-nonce-source
 */

namespace Kenjis\Csp;

class Csp
{
    private static $nonce;
    private static $report_uri = '/csp-report.php';

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

        $header = '';

        if (Browser::supportNonceSource()) {
            $header = "script-src 'nonce-" . static::$nonce . "'";

            if (static::$report_uri) {
                $header .= '; report-uri ' . static::$report_uri;
            }
        }

        if ($header) {
            header('Content-Security-Policy: ' . $header);
        }
    }

    public static function getNonce()
    {
        if (static::$nonce === null) {
            static::generateNonce();
        }

        return static::$nonce;
    }
}
