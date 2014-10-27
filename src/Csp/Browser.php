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

        // https://www.mozilla.org/en-US/mobile/31.0/releasenotes/
        if ($name === 'Firefox' && $version >= 31) {
            return true;
        }
        // At least Chrome 37 supports
        if ($name === 'Chrome' && $version >= 37) {
            return true;
        }

        return false;
    }
}
