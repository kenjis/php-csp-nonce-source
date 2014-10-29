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
    /**
     * @var \Kenjis\Csp\Logger\LoggerInterface
     */
    private $logger;

    /**
     * @param \Kenjis\Csp\Logger\LoggerInterface $logger
     */
    public function __construct(Logger\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $post CSP violation report, JSON string
     */
    public function process($post)
    {
        $report = json_decode($post);

        if ($report) {
            $report->date = date("Y-m-d H:i:s");

            foreach (getallheaders() as $name => $value) {
                $report->headers[$name] = $value;
            }

            $this->logger->log($report);
        }
    }
}
