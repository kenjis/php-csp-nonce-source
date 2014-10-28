<?php

namespace Kenjis\Csp;

use AspectMock\Test as test;

class NonceTest extends TestCase
{
    public function testGetNonce_supportedBrowser()
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $browser = test::double(__NAMESPACE__ . '\Browser', ['supportNonceSource' => true])->make();
        $nonce = new Nonce($browser);

        $test = $nonce->getNonce();
        $expected = 'MTIzNDU2Nzg5MDEyMzQ1Ng==';
        $this->assertEquals($expected, $test);
    }

    public function testGetNonce_unsupportedBrowser()
    {
        test::func(__NAMESPACE__, 'openssl_random_pseudo_bytes', '1234567890123456');
        $browser = test::double(__NAMESPACE__ . '\Browser', ['supportNonceSource' => false])->make();
        $nonce = new Nonce($browser);

        $test = $nonce->getNonce();
        $expected = 'dummy';
        $this->assertEquals($expected, $test);
    }
}
