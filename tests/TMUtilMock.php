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
     * @var resource
     */
    private $stream;

    public function __construct()
    {
        $this->stream = fopen('php://fd/' . self::DESCRIPTOR, 'a');
    }

    public function __destruct()
    {
        fclose($this->stream);
    }

    public function addexclusion(string $path)
    {
        fwrite($this->stream, $path . PHP_EOL);
    }

    public function isexcluded(string $path): bool
    {
        return false;
    }
}
