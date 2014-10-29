<?php

namespace Kenjis\Csp\Logger;

interface LoggerInterface
{
    /**
     * @param \stdClass report object
     */
    public function log(\stdClass $report);
}
