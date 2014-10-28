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

use Kenjis\Csp\Browser\AdapterInterface;

class Browser
{
    /**
     * @var \Kenjis\Csp\Browser\AdapterInterface
     */
    private $browserDetector;

    /**
     * List of browsers and versions which support CSP nonce-source
     *
     * @var array
     */
    private $supportedBrowserList = [
        // name => version
        'Firefox' => 31,    // https://www.mozilla.org/en-US/mobile/31.0/releasenotes/
        'Chrome'  => 37,    // At least Chrome 37 supports CSP nonce-source
    ];

    /**
     * @param \Kenjis\Csp\Browser\AdapterInterface $browserDetector
     */
    public function __construct(AdapterInterface $browserDetector)
    {
        $this->browserDetector = $browserDetector;
    }

    /**
     * Does browser support CSP nonce-source or not?
     *
     * @return boolean
     */
    public function supportNonceSource()
    {
        $name = $this->browserDetector->getName();
        $version = $this->browserDetector->getVersion();

        if (! isset($this->supportedBrowserList[$name])) {
            return false;
        }

        if ($version >= $this->supportedBrowserList[$name]) {
            return true;
        }

        return false;
    }
}
