<?php

namespace Kenjis\Csp\Browser;

class CrossjoinBrowscapTest extends \Kenjis\Csp\TestCase
{
    public function provideUserAgent()
    {
        return [
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:33.0) Gecko/20100101 Firefox/33.0', 'Firefox', 33],
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36', 'Chrome', 38],
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'Safari', 8],
            ['Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20130405 Firefox/22.0', 'Firefox', 22],
        ];
    }

    /**
     * @dataProvider provideUserAgent
     */
    public function test_($userAgent, $browser, $version)
    {
        $browscap = new CrossjoinBrowscap($userAgent);
        $this->assertEquals($browser, $browscap->getName());
        $this->assertEquals($version, $browscap->getVersion());
    }
}
