<?php

namespace Kenjis\CSP;

use AspectMock\Test as test;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        test::clean();
    }
}
