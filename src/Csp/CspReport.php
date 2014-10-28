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

class CspReport
{
    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function process($post)
    {
        $report = json_decode($post);

        if ($report) {
            $report->date = date("Y-m-d H:i:s");

            foreach (getallheaders() as $name => $value) {
                $report->headers[$name] = $value;
            }

            $data = json_encode(
                $report,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );

            $this->logger->log('info', $data);
        }
    }
}
