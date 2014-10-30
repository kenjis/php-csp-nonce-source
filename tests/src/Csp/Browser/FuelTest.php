<?php

namespace Kenjis\Csp\Browser;

require __DIR__ . '/../../Fake/Agent.php';

class FuelTest extends \Kenjis\Csp\TestCase
{
    /**
     * @dataProvider provideAgents
     */
    public function test_($browser, $version, $expectedName, $expectedVersion)
    {
        \Agent::_init($browser, $version);

        $fuel = new Fuel();

        $this->assertSame($expectedName, $fuel->getName());
        $this->assertSame($expectedVersion, $fuel->getVersion());
    }

    public function provideAgents()
    {
        return [
            ['Firefox', 33.0, 'Firefox', 33],
            ['Chrome',  38.0, 'Chrome',  38],
        ];
    }
}
