<?php

namespace Kenjis\Csp;

use AspectMock\Test as test;

class CspTest extends TestCase
{
    public function testGetNonce()
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');

        $test = CSP::getNonce();
        $expected = 'MTIzNDU2Nzg5MDEyMzQ1Ng==';
        $this->assertEquals($expected, $test);
    }

    /**
     * @dataProvider provideSupportedBrowser
     */
    public function testSetHeader_supportedBrowser($browser)
    {
        $_SERVER['HTTP_USER_AGENT'] = $browser;

        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $func = test::func(__NAMESPACE__, 'header', '');

        $test = CSP::setHeader();

        $func->verifyInvoked(
            ["Content-Security-Policy: script-src 'nonce-MTIzNDU2Nzg5MDEyMzQ1Ng=='; report-uri /csp-report.php"]
        );
    }

    public function provideSupportedBrowser()
    {
        return [
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0'],
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36'],
        ];
    }
}
