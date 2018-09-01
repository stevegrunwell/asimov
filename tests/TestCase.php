<?php
/**
 * A base test case for all other tests in the suite.
 *
 * @package Asimov
 */

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @var string The temp directory that will act as our dummy home directory.
     */
    private static $homeDir;

    /**
     * Prepare the dummy filesystem by creating a unique directory in the temp directory.
     *
     * @beforeClass
     */
    public static function configurePath()
    {
        self::$homeDir = sys_get_temp_dir() . '/asimov/' . uniqid();
    }

    /**
     * Clean up the temp directory after each test method.
     *
     * @link https://stackoverflow.com/a/3352564/329911
     *
     * @after
     */
    public function cleanTempDir()
    {
        // If we haven't written anything, there's nothing to do.
        if (! is_dir(self::$homeDir)) {
            return;
        }

        // Locate and clean up all of the files and subdirectories.
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(self::$homeDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }

    /**
     * Destroy the temp directory at the conclusion of the test suite.
     *
     * @afterClass
     */
    public static function removeTempDir()
    {
        rmdir(self::$homeDir);
    }

    /**
     * Execute the local copy of Asimov.
     *
     * @return array An array of excluded filepaths.
     */
    protected function asimov(): array
    {
        $descriptors = [
            1 =>                      ['pipe', 'w'],
            TMUtilMock::DESCRIPTOR => ['pipe', 'w'],
        ];
        $env = [
            'HOME' => self::$homeDir,
            'PATH' => __DIR__ . '/bin:' . getenv('PATH'),
        ];
        $process = proc_open(dirname(__DIR__) . '/asimov', $descriptors, $pipes, null, $env);

        if (! is_resource($process)) {
            trigger_error('Unable to call Asimov via proc_open().', E_USER_ERROR);
        }

        $excluded = stream_get_contents($pipes[TMUtilMock::DESCRIPTOR]);

        proc_close($process);

        return array_filter(explode(PHP_EOL, $excluded));
    }

    /**
     * Retrieve the full system path, relative to the temporary home directory.
     *
     * @param string $path Optional. The path to include.
     *
     * @return string The full system path to the given path within the home directory.
     */
    protected function getFilepath(string $path = ''): string
    {
        $base = self::$homeDir;

        if ('/' !== substr($base, -1, 1)) {
            $base .= '/';
        }

        if ('/' === substr($path, 0, 1)) {
            $path = substr($path, 1);
        }

        return $base . $path;
    }

    /**
     * Create dummy files within our dummy filesystem.
     *
     * A multi-dimensional array will be treated as a series of nested directories, using keys
     * as directory names; non-array values will be written as file contents.
     *
     * For example, consider the following $structure array:
     *
     *   [
     *     'parent-dir' => [
     *       'child-dir' => [
     *         'file.txt' => 'These are the contents of parent-dir/child-dir/file.txt',
     *       ],
     *       'readme.txt' => 'This is the README file.',
     *     ],
     *   ]
     *
     * That array would produce a directory structure (within self::$homeDir) that looks like:
     *
     *   - parent-dir/
     *    |- child-dir/
     *      |- file.txt
     *    |- readme.txt
     *
     * @param array $structure
     */
    protected function createDirectoryStructure(array $structure)
    {
        @mkdir(self::$homeDir, 0777, true);

        foreach ($structure as $name => $data) {
            $this->populateFilesystem($name, $data);
        }
    }

    /**
     * Create a new directory in the dummy filesystem.
     *
     * This function is written to be called recursively, in order to populate nested arrays.
     *
     * @param string $name The directory or filename to create.
     * @param mixed  $data The data to associate with the name; arrays will be treated as
     *                     sub-directories, while everything else will be written to files.
     */
    private function populateFilesystem(string $name, $data)
    {
        if (is_array($data)) {
            @mkdir(self::$homeDir . DIRECTORY_SEPARATOR . $name, 0777, true);

            foreach ($data as $subdir => $subdata) {
                $this->populateFilesystem($name . DIRECTORY_SEPARATOR . $subdir, $subdata);
            }
        } else {
            file_put_contents(self::$homeDir . DIRECTORY_SEPARATOR . $name, $data);
        }
    }
}
