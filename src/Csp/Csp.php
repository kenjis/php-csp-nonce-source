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

class Csp
{
    public $report_uri = '/csp-report.php';

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
            $this->nonce = 'dummy';
            return;
        }

        $length = 16;
        $bytes = '';
        if (function_exists('openssl_random_pseudo_bytes')) {
            $usable = true;
            $bytes = openssl_random_pseudo_bytes($length, $usable);
            if ($usable === false) {
                // weak
            }
        } else {
            throw new Exception('Can\'t use openssl_random_pseudo_bytes');
        }

        $this->nonce = base64_encode($bytes);
    }

    public function setHeader()
    {
        if ($this->nonce === null) {
            $this->generateNonce();
        }

        $header = '';

        if ($this->browser->supportNonceSource()) {
            $header = "script-src 'nonce-" . $this->nonce . "'";

            if ($this->report_uri) {
                $header .= '; report-uri ' . $this->report_uri;
            }
        }

        if ($header) {
            header('Content-Security-Policy: ' . $header);
        }
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
