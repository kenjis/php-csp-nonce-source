<?php

namespace Kenjis\Csp;

use AspectMock\Test as test;

class CspReportTest extends TestCase
{
    public function setUp()
    {
        $this->obj = new CspReport('dummy');
    }

    public function testProcess()
    {
        test::func(__NAMESPACE__, 'getallheaders', ["Host" => "localhost:8000"]);
        test::func(__NAMESPACE__, 'date', '2014-10-26 05:55:43');
        $func = test::func(__NAMESPACE__, 'file_put_contents', true);

        $post = <<<'EOD'
{"csp-report":{"document-uri":"http://localhost:8000/","referrer":"","violated-directive":"script-src 'nonce-Q6m8petbOPneeedes1gaMQ=='","original-policy":"script-src 'nonce-Q6m8petbOPneeedes1gaMQ=='; report-uri /csp-report.php","blocked-uri":"","status-code":200}}
EOD;

        $this->obj->process($post);

        $data = <<<'EOD'
{
    "csp-report": {
        "document-uri": "http://localhost:8000/",
        "referrer": "",
        "violated-directive": "script-src 'nonce-Q6m8petbOPneeedes1gaMQ=='",
        "original-policy": "script-src 'nonce-Q6m8petbOPneeedes1gaMQ=='; report-uri /csp-report.php",
        "blocked-uri": "",
        "status-code": 200
    },
    "date": "2014-10-26 05:55:43",
    "headers": {
        "Host": "localhost:8000"
    }
}
EOD;
        $func->verifyInvoked(
            ['dummy', $data . "\n", LOCK_EX | FILE_APPEND]
        );
    }
}
