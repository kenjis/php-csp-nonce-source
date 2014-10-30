<?php
/**
 * CSP
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/php-csp-nonce-source
 */

namespace Kenjis\Csp\Browser;

/**
 * Browser Detector using FuelPHP v1 Agent class
 *
 * user agent string is fetched from $_SERVER.
 */
class Fuel implements AdapterInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        // @TODO What about IE?
        return \Agent::browser();
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return (int) \Agent::version();
    }
}
