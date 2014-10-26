<?php
require __DIR__ . '/vendor/autoload.php';

http_response_code(204);

$post = file_get_contents('php://input');
if (! $post) {
    exit;
}

$report = new CspReport();
$report->process($post);
