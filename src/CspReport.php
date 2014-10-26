<?php

class CspReport
{
    public function process($post)
    {
        $report = json_decode($post);

        if ($report) {
            $report->{'user-agent'} = $_SERVER['HTTP_USER_AGENT'];

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
