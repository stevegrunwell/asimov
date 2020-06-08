<?php
/**
 * A mock implementation of Apple's Time Machine utility (tmutil).
 *
 * @package Asimov
 */

namespace Tests;

class TMUtilMock
{
    /**
     * @var int The PHP stream descriptor used for the mock.
     */
    const DESCRIPTOR = 4;

    /**
     * @var array
     */
    private $exclusions;

    /**
     * @var resource
     */
    private $stream;

    public function __construct()
    {
        $this->stream = fopen('php://fd/' . self::DESCRIPTOR, 'a');

        // Read any exclusions set in the environment.
        $this->exclusions = explode(',', (string) getenv('KNOWN_EXCLUSIONS'));
    }

    public function __destruct()
    {
        fclose($this->stream);
    }

    public function addexclusion(string $path)
    {
        $this->exclusions[] = $path;

        fwrite($this->stream, $path . PHP_EOL);
    }

    /**
     * Determines whether or not the given $path has already been excluded.
     *
     * @param string $path The filepath to check.
     */
    public function isexcluded(string $path)
    {
        $status = in_array($path, $this->exclusions, true) ? 'Excluded' : 'Included';

        fwrite(STDOUT, "[$status]\t{$path}");
    }
}
