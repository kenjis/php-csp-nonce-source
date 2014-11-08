<?php

namespace Kenjis\Csp\Browser;

class CrossjoinBrowscapTest extends AbstractBrowserTest
{
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
