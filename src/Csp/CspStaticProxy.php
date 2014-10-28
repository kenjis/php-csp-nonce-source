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
    public static $browserDetectorAdapter = 'Woothee';
    public static $report_uri = '/csp-report.php';

    /**
     * @var \Kenjis\Csp\Csp
     */
    protected static $csp;

    protected static function createCsp()
    {
        if (static::$csp !== null) {
            return;
        }

        $className = __NAMESPACE__ . '\\Browser\\' . static::$browserDetectorAdapter;
        $browserDetector = new $className($_SERVER['HTTP_USER_AGENT']);
        $browser = new Browser($browserDetector);
        static::$csp = new Csp($browser);
        static::$csp->report_uri = static::$report_uri;
    }

    public static function setHeader()
    {
        static::createCsp();
        return static::$csp->setHeader();
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
