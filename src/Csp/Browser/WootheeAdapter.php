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

class WootheeAdapter
{
    private $browser = [];

    public function __construct()
    {
        $classifier = new Classifier;
        $this->browser = $classifier->parse($_SERVER['HTTP_USER_AGENT']);;
    }

    public function getName()
    {
        return $this->browser['name'];
    }

    public function getVersion()
    {
        $tmp = explode('.', $this->browser['version']);
        return (int) $tmp[0];
    }
}
