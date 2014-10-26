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
    private static $browser = [];

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

        if (static::supportNonceSource()) {
            $header = "script-src 'nonce-" . static::$nonce . "'";

            if (static::$report_uri) {
                $header .= '; report-uri ' . static::$report_uri;
            }
        }

        if ($header) {
            header('Content-Security-Policy: ' . $header);
        }
    }

    private static function getBrowserInfo()
    {
        if (static::$browser === []) {
            $classifier = new \Woothee\Classifier;
            static::$browser = $classifier->parse($_SERVER['HTTP_USER_AGENT']);
        }
    }

    /**
     * Does Browser support CSP nonce-source or not?
     *
     * @return boolean
     */
    private static function supportNonceSource()
    {
        static::getBrowserInfo();
        $name = static::$browser['name'];

        $tmp = explode(".", static::$browser['version']);
        $version = (int) $tmp[0];

        // At least Firefox 33 supports
        if ($name === 'Firefox' && $version >= 33) {
            return true;
        }
        // At least Chrome 38 supports
        if ($name === 'Chrome' && $version >= 38) {
            return true;
        }

        return false;
    }

    public static function getNonce()
    {
        if (static::$nonce === null) {
            static::generateNonce();
        }

        return static::$nonce;
    }
}
