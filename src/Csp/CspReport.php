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
    private $logfile;

    public function __construct($logfile)
    {
        $this->logfile = $logfile;
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

            $this->log($data);
        }
    }

    /**
     * @param string $data
     */
    private function log($data)
    {
        file_put_contents($this->logfile, $data . "\n", LOCK_EX | FILE_APPEND);
    }
}
