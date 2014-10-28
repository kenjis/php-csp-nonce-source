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

class Nonce
{
    const UNSUPPORTED_BROWSER_NONCE = 'dummy';

    /**
     * @var \Kenjis\Csp\Browser
     */
    private $browser;

    /**
     * @var string
     */
    private $nonce;

    /**
     * @param \Kenjis\Csp\Browser $browser
     */
    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    private function generateNonce()
    {
        if (! $this->browser->supportNonceSource()) {
            $this->nonce = static::UNSUPPORTED_BROWSER_NONCE;
            return;
        }

        $length = 16;
        $usable = true;
        $bytes = openssl_random_pseudo_bytes($length, $usable);
        if ($usable === false) {
            // weak
            // @TODO do something?
        }

        $this->nonce = base64_encode($bytes);
    }

    /**
     * @return string
     */
    public function getNonce()
    {
        if ($this->nonce === null) {
            $this->generateNonce();
        }

        return $this->nonce;
    }
}
