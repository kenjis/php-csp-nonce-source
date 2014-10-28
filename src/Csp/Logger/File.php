<?php
/**
 * CSP
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2014 Kenji Suzuki
 * @link       https://github.com/kenjis/php-csp-nonce-source
 */

namespace Kenjis\Csp\Logger;

class File
{
    /**
     * @var string
     */
    private $logfile;

    /**
     * @param string $logfile
     */
    public function __construct($logfile)
    {
        $this->logfile = $logfile;
    }

    /**
     * @param string $level log level, but not used
     * @param string $message
     */
    public function log($level, $message)
    {
        file_put_contents($this->logfile, $message . "\n", LOCK_EX | FILE_APPEND);
    }
}
