<?php
/**
 * CSP
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/php-csp-nonce-source
 */

class CspReport
{
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

    private function log($data)
    {
        $logfile = dirname(__DIR__) . '/csp-report.log';
        file_put_contents($logfile, $data . "\n", LOCK_EX | FILE_APPEND);
    }
}
