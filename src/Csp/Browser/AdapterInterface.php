<?php

namespace Kenjis\Csp\Browser;

interface AdapterInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return integer
     */
    public function getVersion();
}
