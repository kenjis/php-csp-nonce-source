<?php

/**
 * Fake FuelPHP v1 Agent class
 */
class Agent
{
    protected static $browser;
    protected static $version;

    public static function _init($browser, $version)
    {
        static::$browser = $browser;
        static::$version = $version;
    }

    public static function browser()
    {
        return static::$browser;
    }

    public static function version()
    {
        return static::$version;
    }
}
