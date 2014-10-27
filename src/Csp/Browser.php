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

    protected static $browserDetector;

    protected static $supportedBrowserList = [
        // name => version
        'Firefox' => 31,    // https://www.mozilla.org/en-US/mobile/31.0/releasenotes/
        'Chrome'  => 37,    // At least Chrome 37 supports CSP nonce-source
    ];

    protected static function createBrowserDetector()
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

        if (isset(static::$supportedBrowserList[$name])) {
            if ($version >= static::$supportedBrowserList[$name]) {
                return true;
            }
        }

        return false;
    }
}
