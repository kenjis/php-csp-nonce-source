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

interface AdapterInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return integer
     */
    public function getVersion();
}
