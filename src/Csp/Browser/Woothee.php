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

use Woothee\Classifier;

class Woothee implements AdapterInterface
{
    private $browser = [];

    /**
     * @param string $userAgent user agent string
     */
    public function __construct($userAgent)
    {
        $classifier = new Classifier;
        $this->browser = $classifier->parse($userAgent);;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->browser['name'];
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        $tmp = explode('.', $this->browser['version']);
        return (int) $tmp[0];
    }
}
