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

class Browser
{
    public static $browserDetectorAdapter = 'WootheeAdapter';

    private static $browserDetector;

    private static function createBrowserDetector()
    {
        $className = __NAMESPACE__ . '\\Browser\\' . static::$browserDetectorAdapter;
        static::$browserDetector = new $className;
    }

    /**
     * Does Browser support CSP nonce-source or not?
     *
     * @return boolean
     */
    public static function supportNonceSource()
    {
        static::createBrowserDetector();
        $name = static::$browserDetector->getName();
        $version = static::$browserDetector->getVersion();

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
}
