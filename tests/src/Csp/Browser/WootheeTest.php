<?php

namespace Kenjis\Csp\Browser;

class WootheeTest extends AbstractBrowserTest
{
    /**
     * @dataProvider provideUserAgent
     */
    public function test_($userAgent, $browser, $version)
    {
        $parser = new Woothee($userAgent);
        $this->assertEquals($browser, $parser->getName());
        $this->assertEquals($version, $parser->getVersion());
    }
}
