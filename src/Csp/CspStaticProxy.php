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

class CspStaticProxy
{
    public static $browserDetector = 'Woothee';

    /**
     * @var \Kenjis\Csp\Csp
     */
    protected static $csp;

    protected static function createCsp()
    {
        if (static::$csp !== null) {
            return;
        }

        $className = __NAMESPACE__ . '\\Browser\\' . static::$browserDetector;
        $browserDetector = new $className($_SERVER['HTTP_USER_AGENT']);
        $browser = new Browser($browserDetector);
        $nonce = new Nonce($browser);
        static::$csp = new Csp($nonce);
        static::$csp->setNonceSource();
        static::$csp->addPolicy('report-uri', '/csp-report.php');
    }

    public static function setHeader()
    {
        static::createCsp();
        static::$csp->setHeader();
    }

    /**
     * @param string $directive
     * @param string $value
     */
    public static function addPolicy($directive, $value)
    {
        static::createCsp();
        static::$csp->addPolicy($directive, $value);
    }

    /**
     * @return string
     */
    public static function getNonce()
    {
        static::createCsp();
        return static::$csp->getNonce();
    }

    public static function resetCsp()
    {
        static::$csp = null;
    }
}
