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

    public function createCspWithSupportedBrowser()
    {
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0';
        $browserDetector = new Browser\Woothee($userAgent);
        $browser = new Browser($browserDetector);
        $nonce = new Nonce($browser);
        $this->csp = new Csp($nonce);
    }

    public function test_addPolicy_oneDirective()
    {
        $this->createCspWithSupportedBrowser();
        $this->csp->addPolicy('connect-src', 'example.com');

        $test = (string) $this->csp;
        $expected = "connect-src example.com";
        $this->assertEquals($expected, $test);
    }

    public function test_addPolicy_keywordsWithQuotation()
    {
        $this->createCspWithSupportedBrowser();
        $this->csp->addPolicy('default-src', 'self');

        $test = (string) $this->csp;
        $expected = "default-src 'self'";
        $this->assertEquals($expected, $test);
    }

    public function test_addPolicy_twoDirectives()
    {
        $this->createCspWithSupportedBrowser();
        $this->csp->addPolicy('default-src', 'self');
        $this->csp->addPolicy('img-src', '*');

        $test = (string) $this->csp;
        $expected = "default-src 'self'; img-src *";
        $this->assertEquals($expected, $test);
    }

    public function test_addPolicy_twoValues()
    {
        $this->createCspWithSupportedBrowser();
        $this->csp->addPolicy('default-src', 'https:');
        $this->csp->addPolicy('default-src', 'unsafe-inline');

        $test = (string) $this->csp;
        $expected = "default-src https: 'unsafe-inline'";
        $this->assertEquals($expected, $test);
    }

    public function test_addPolicy_duplicatedValues()
    {
        $this->createCspWithSupportedBrowser();
        $this->csp->addPolicy('default-src', 'self');
        $this->csp->addPolicy('default-src', 'self');

        $test = (string) $this->csp;
        $expected = "default-src 'self'";
        $this->assertEquals($expected, $test);
    }

    public function test_sendHeader_emptyHeader()
    {
        $func = test::func(__NAMESPACE__, 'header', '');

        $this->createCspWithSupportedBrowser();

        $test = $this->csp->sendHeader();
        $func->verifyNeverInvoked();
    }

    public function test_sendHeader_reportOnly()
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $func = test::func(__NAMESPACE__, 'header', '');

        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0';
        $this->createCsp($userAgent);
        $this->csp->setReportOnly();

        $test = $this->csp->sendHeader();
        $func->verifyInvoked(
            ["Content-Security-Policy-Report-Only: script-src 'nonce-MTIzNDU2Nzg5MDEyMzQ1Ng=='; report-uri /csp-report.php"]
        );
    }

    /**
     * @dataProvider provideSupportedBrowser
     */
    public function test_sendHeader_supportedBrowser($userAgent)
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $func = test::func(__NAMESPACE__, 'header', '');

        $this->createCsp($userAgent);

        $test = $this->csp->sendHeader();
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
    public function test_sendHeader_unsupportedBrowser($userAgent)
    {
        $func = test::func(__NAMESPACE__, 'header', '');

        $this->createCsp($userAgent);

        $test = $this->csp->sendHeader();
        $func->verifyNeverInvoked();
    }

    public function provideUnsupportedBrowser()
    {
        return [
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25'],
            ['Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20130405 Firefox/22.0'],
        ];
    }
}
