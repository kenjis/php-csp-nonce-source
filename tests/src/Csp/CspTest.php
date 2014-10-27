<?php

namespace Kenjis\Csp;

use AspectMock\Test as test;

class CspTest extends TestCase
{
    public function setUp()
    {
        CSP::resetNonce();
    }

    public function testGetNonce_supportedBrowser()
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        test::double(__NAMESPACE__ . '\Browser', ['supportNonceSource' => true]);

        $test = CSP::getNonce();
        $expected = 'MTIzNDU2Nzg5MDEyMzQ1Ng==';
        $this->assertEquals($expected, $test);
    }

    public function testGetNonce_unsupportedBrowser()
    {
        test::double(__NAMESPACE__ . '\Browser', ['supportNonceSource' => false]);

        $test = CSP::getNonce();
        $expected = 'dummy';
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

    /**
     * @dataProvider provideUnsupportedBrowser
     */
    public function testSetHeader_unsupportedBrowser($browser)
    {
        $_SERVER['HTTP_USER_AGENT'] = $browser;

        $func = test::func(__NAMESPACE__, 'header', '');

        $test = CSP::setHeader();

        $func->verifyNeverInvoked();
    }

    public function provideUnsupportedBrowser()
    {
        return [
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25'],
        ];
    }
}
