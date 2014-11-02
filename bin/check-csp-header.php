<?php
/**
 * CSP
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/php-csp-nonce-source
 */

if ($argc !== 2) {
    echo 'Check CSP header of a web page' . PHP_EOL . PHP_EOL;
    echo 'Usage:' . PHP_EOL;
    echo ' php ' . $argv[0] . ' <url>' . PHP_EOL;
    exit;
}

$url = $argv[1];
$components = parse_url($url);
$scheme = $components['scheme'];

$userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36';
$context = stream_context_create([
    $scheme => [
        'method' => 'GET',
        'header' => 'User-Agent: ' . $userAgent . "\r\n",
    ]
]);
$ret = file_get_contents($url, false, $context);

if ($ret === false) {
    echo 'Can\'t get ' . $url . PHP_EOL;
    exit(1);
}

$cspHeader = 'content-security-policy';
$length = strlen($cspHeader);
foreach ($http_response_header as $header) {
    if (strtolower(substr($header, 0, $length)) === $cspHeader) {
        echo 'Raw Header:' .PHP_EOL;
        echo ' ' . $header . PHP_EOL . PHP_EOL;

        $fieldName = substr($header, 0, $length);
        echo $fieldName . ':' . PHP_EOL;

        $fieldValue = substr($header, $length + 1);
        $directives = explode(';', $fieldValue);
        foreach ($directives as $directive) {
            echo $directive . ';' . PHP_EOL;
        }
    }
}
