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

/**
 * CSP
 *
 * See http://www.w3.org/TR/CSP2/
 */
class Csp
{
    /**
     *
     * @var \Kenjis\CspNonce
     */
    private $nonce;

    private $policies = [];

    private $reportOnly = false;

    public function __construct(Nonce $nonce)
    {
        $this->nonce = $nonce;
    }

    /**
     * @param string $directive
     * @param string $value
     */
    public function addPolicy($directive, $value)
    {
        // with quotation
        $keywords = ['self', 'unsafe-inline', 'unsafe-eval', 'unsafe-redirect'];
        if (in_array($value, $keywords)) {
            $value = "'" . $value . "'";
        }

        $this->policies[$directive][] = $value;
        $tmp = array_unique($this->policies[$directive]);
        $this->policies[$directive] = $tmp;
    }

    public function getNonce()
    {
        return $this->nonce->getNonce();
    }

    public function setNonceSource()
    {
        $nonce = $this->nonce->getNonce();
        $value = "'" . 'nonce-' . $nonce . "'";
        $this->addPolicy('script-src', $value);
    }

    public function setReportOnly()
    {
        $this->reportOnly = true;
    }

    public function setHeader()
    {
        if (! $this->reportOnly) {
            $fieldName = 'Content-Security-Policy';
        } else {
            $fieldName = 'Content-Security-Policy-Report-Only';
        }

        // Send CSP header only to browsers which supports nonce-source
        if ($this->nonce->getNonce() !== Nonce::UNSUPPORTED_BROWSER_NONCE) {
            header($fieldName . ': ' . $this);
        }
    }

    public function __toString()
    {
        $string = '';
        foreach ($this->policies as $directive => $values) {
            $string .= $directive . ' ' . implode(' ', $values) . '; ';
        }

        return rtrim($string, '; ');
    }
}
