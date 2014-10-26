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

use Woothee\Classifier;

class Browser
{
    private static $browser = [];

    private static function getBrowserInfo()
    {
        $classifier = new Classifier;
        static::$browser = $classifier->parse($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Does Browser support CSP nonce-source or not?
     *
     * @return boolean
     */
    public static function supportNonceSource()
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
}
