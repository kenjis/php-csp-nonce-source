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
 * Browser Detector using Crossjoin\Browscap
 */
class CrossjoinBrowscap implements AdapterInterface
{
    /**
     * @var stdClass
     */
    private $browser;

    /**
     * @param string $userAgent user agent string
     */
    public function __construct($userAgent)
    {
        $browscap = new \Crossjoin\Browscap\Browscap();
        $this->browser = $browscap->getBrowser($userAgent)->getData();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->browser->browser;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return (int) $this->browser->version;
    }
}
