<?php

namespace Kenjis\Csp;

use AspectMock\Test as test;

class CspTest extends TestCase
{
    public function createCsp($userAgent)
    {
        $browserDetector = new Browser\Woothee($userAgent);
        $browser = new Browser($browserDetector);
        $nonce = new Nonce($browser);
        $this->csp = new Csp($nonce);
        $this->csp->setNonceSource();
        $this->csp->addPolicy('report-uri', '/csp-report.php');
    }

    public function testSetHeader_emptyHeader()
    {
        $func = test::func(__NAMESPACE__, 'header', '');

        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0';
        $browserDetector = new Browser\Woothee($userAgent);
        $browser = new Browser($browserDetector);
        $nonce = new Nonce($browser);
        $this->csp = new Csp($nonce);

        $test = $this->csp->setHeader();
        $func->verifyNeverInvoked();
    }

    public function testSetHeader_reportOnly()
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $func = test::func(__NAMESPACE__, 'header', '');

        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0';
        $this->createCsp($userAgent);
        $this->csp->setReportOnly();

        $test = $this->csp->setHeader();
        $func->verifyInvoked(
            ["Content-Security-Policy-Report-Only: script-src 'nonce-MTIzNDU2Nzg5MDEyMzQ1Ng=='; report-uri /csp-report.php"]
        );
    }

    public function testAddPolicy_keywordsWithQuotation()
    {
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0';
        $browserDetector = new Browser\Woothee($userAgent);
        $browser = new Browser($browserDetector);
        $nonce = new Nonce($browser);
        $this->csp = new Csp($nonce);
        $this->csp->addPolicy('default-src', 'self');

        $test = (string) $this->csp;
        $expected = "default-src 'self'";
        $this->assertEquals($expected, $test);
    }

    /**
     * @dataProvider provideSupportedBrowser
     */
    public function testSetHeader_supportedBrowser($userAgent)
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $func = test::func(__NAMESPACE__, 'header', '');

        $this->createCsp($userAgent);

        $test = $this->csp->setHeader();
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
    public function testSetHeader_unsupportedBrowser($userAgent)
    {
        $func = test::func(__NAMESPACE__, 'header', '');

        $this->createCsp($userAgent);

        $test = $this->csp->setHeader();
        $func->verifyNeverInvoked();
    }

    public function provideUnsupportedBrowser()
    {
        return [
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25'],
        ];
    }
}
