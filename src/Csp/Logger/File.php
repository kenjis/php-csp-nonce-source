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

class File implements LoggerInterface
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
     * @param \stdClass report object
     */
    public function log(\stdClass $report)
    {
        $data = json_encode(
            $report,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );

        file_put_contents($this->logfile, $data . "\n", LOCK_EX | FILE_APPEND);
    }
}
