<?php

require __DIR__ . '/bootstrap.php';

use Kenjis\Csp\Logger\File;
use Kenjis\Csp\CspReport;

http_response_code(204);

$post = file_get_contents('php://input');
if (! $post) {
    exit;
}

$logfile = __DIR__ . '/csp-report.log';
$logger = new File($logfile);
$report = new CspReport($logger);
$report->process($post);
